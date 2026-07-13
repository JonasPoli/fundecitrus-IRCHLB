<?php

namespace App\Command;

use App\Entity\AirportGuide;
use App\Entity\AgendaActivity;
use App\Entity\CommitteeMember;
use App\Entity\ContactMessage;
use App\Entity\EventConfig;
use App\Entity\EventDay;
use App\Entity\FaqCategory;
use App\Entity\FaqItem;
use App\Entity\Image;
use App\Entity\PageContent;
use App\Entity\PartnerHotel;
use App\Entity\RegistrationBatch;
use App\Entity\RestaurantRecommendation;
use App\Entity\Speaker;
use App\Entity\SpeakerAgenda;
use App\Entity\SpeakerPaper;
use App\Entity\Sponsor;
use App\Entity\SponsorshipInquiry;
use App\Entity\SponsorshipTier;
use App\Entity\StatisticItem;
use App\Entity\ThematicGroup;
use App\Entity\VenueRoom;
use App\Entity\HomeBanner;
use App\Entity\Organizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:seed-data',
    description: 'Seeds the database with rich mock data for the IRCHLB 2027 conference.',
)]
class SeedDataCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Starting Database Seeding for IRCHLB 2027');

        // 1. Limpeza do Banco de Dados
        $io->section('Cleaning existing database tables...');
        $conn = $this->entityManager->getConnection();
        $conn->executeStatement('SET FOREIGN_KEY_CHECKS = 0;');
        
        $tables = [
            'contact_message', 'sponsorship_inquiry', 'faq_item', 'faq_category',
            'restaurant_recommendation', 'partner_hotel', 'airport_guide',
            'sponsor', 'sponsorship_tier', 'agenda_activity_speaker', 'agenda_activity',
            'speaker_paper', 'speaker_agenda', 'speaker', 'venue_room', 'event_day',
            'thematic_group', 'registration_batch', 'committee_member',
            'page_content', 'statistic_item', 'event_config', 'image', 'home_banner',
            'newsletter_request', 'organizer'
        ];
        
        foreach ($tables as $table) {
            $conn->executeStatement("DELETE FROM `{$table}`");
            $conn->executeStatement("ALTER TABLE `{$table}` AUTO_INCREMENT = 1");
        }
        
        $conn->executeStatement('SET FOREIGN_KEY_CHECKS = 1;');
        $io->success('Database cleaned successfully!');

        // 2. Configurações de Origem e Destino de Mídias
        $layoutImagesDir = $this->projectDir . '/docs/imagens/seed';
        $logosImagesDir = $this->projectDir . '/docs/imagens/logos';
        $uploadDestinationDir = $this->projectDir . '/public/uploads';

        // Limpeza dos arquivos físicos de uploads anteriores do seed
        if (is_dir($uploadDestinationDir)) {
            $files = glob($uploadDestinationDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        } else {
            mkdir($uploadDestinationDir, 0777, true);
        }

        // Helper para upload de imagens
        $uploadImage = function (string $sourcePath, string $type = 'other') use ($uploadDestinationDir, $io): ?Image {
            if (!file_exists($sourcePath)) {
                $io->warning("Source file not found: " . $sourcePath);
                return null;
            }
            
            $filename = md5(uniqid() . basename($sourcePath)) . '.' . pathinfo($sourcePath, PATHINFO_EXTENSION);
            $destPath = $uploadDestinationDir . '/' . $filename;
            
            copy($sourcePath, $destPath);
            
            $image = new Image();
            $image->setImageName($filename);
            $image->setType($type);
            $this->entityManager->persist($image);
            
            return $image;
        };

        // 3. Injeção de Dados: EventConfig
        $io->section('Seeding EventConfig...');
        $eventConfig = new EventConfig();
        $eventConfig->setTitle('VIII International Research Conference on Huanglongbing');
        $eventConfig->setSubtitle('Join the global scientific community in Ribeirão Preto, Brazil, to discuss the most rigorous advancements against HLB.');
        $eventConfig->setEventDates('October 25-29, 2027');
        $eventConfig->setLocationName('Multiplan Hall – RibeirãoShopping');
        $eventConfig->setAddressStreet('Av. Cel. Fernando Ferreira Leite, 1540');
        $eventConfig->setAddressNeighborhood('Jardim California');
        $eventConfig->setAddressCity('Ribeirão Preto, SP');
        $eventConfig->setAddressZipCode('14026-900');
        $eventConfig->setGoogleMapsUrl('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.646875881452!2d-47.81745422396116!3d-21.206173080488667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94b9be39e5555555%3A0x4a480e6c64187042!2sRibeir%C3%A3oShopping!5e0!3m2!1sen!2sbr!4v1700000000000!5m2!1sen!2sbr');
        $eventConfig->setHeroDescription('The VIII International Research Conference on Huanglongbing represents the most vital academic and operational convergence point for discussing, mapping, and confronting the HLB citrus disease. Our root conceptual objective is to foster deep collaboration across borders.');
        
        $heroImage = $uploadImage($layoutImagesDir . '/hero-bg.jpg', 'hero');
        if ($heroImage) {
            $eventConfig->setHeroImage($heroImage);
        }
        
        $prospectusFile = $uploadImage($layoutImagesDir . '/conference-room.jpg', 'prospectus'); // Usando conference-room como mockup do PDF
        if ($prospectusFile) {
            $eventConfig->setProspectusFile($prospectusFile);
        }
        
        $eventConfig->setSupportEmail('support@irchlb2027.org');
        $eventConfig->setSupportPhone('+55 (16) 3301-7000');
        $eventConfig->setWhatsappNumber('+5516999999999');
        $eventConfig->setLinkedinUrl('https://www.linkedin.com/company/fundecitrus');
        $eventConfig->setInstagramUrl('https://www.instagram.com/fundecitrus');
        $eventConfig->setYoutubeUrl('https://www.youtube.com/user/Fundecitrus');
        
        $this->entityManager->persist($eventConfig);

        // 3.1. Injeção de Dados: HomeBanner
        $io->section('Seeding HomeBanners...');
        $banner = new HomeBanner();
        $banner->setEventDate('October 25–29, 2027');
        $banner->setSubtitle('CONFERENCE INFORMATION');
        $banner->setMainTitle('Two Conferences. One Global Community. One Shared Mission.');
        $banner->setDescription1('XXIV IOCV Conference: October 25, 2027');
        $banner->setDescription('VIII IRCHLB: October 26–29, 2027');
        $banner->setButton1Text('Register Now');
        $banner->setButton1Link('/inscricoes');
        $banner->setButton2Text('Call for Papers');
        $banner->setButton2Link('/submissao');
        $banner->setPosition(1);
        $banner->setIsActive(true);
        if ($heroImage) {
            $banner->setImage($heroImage);
        }
        $this->entityManager->persist($banner);

        // 4. Injeção de Dados: StatisticItem
        $io->section('Seeding StatisticItems...');
        $stats = [
            ['value' => '500+', 'label' => 'Expected Participants'],
            ['value' => '25+', 'label' => 'Countries Reached'],
            ['value' => '100+', 'label' => 'Approved Papers'],
            ['value' => '5', 'label' => 'Days of Content']
        ];
        foreach ($stats as $idx => $statData) {
            $statItem = new StatisticItem();
            $statItem->setValue($statData['value']);
            $statItem->setLabel($statData['label']);
            $statItem->setPosition($idx + 1);
            $statItem->setIsActive(true);
            $this->entityManager->persist($statItem);
        }

        // 5. Injeção de Dados: PageContent (Páginas Extras)
        $io->section('Seeding PageContent (Extra Pages)...');
        $policies = [
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'content' => '<h3>1. Data Collection</h3><p>We collect personal information necessary for the registration and communication of the IRCHLB 2027 conference. This information will only be used to facilitate your participation and answer inquiries.</p><h3>2. GDPR & LGPD Compliance</h3><p>We strictly respect Brazil\'s LGPD regulations and global GDPR guidelines. You have the right to request deletion or modification of your data at any time by contacting our support channels.</p>'
            ],
            [
                'slug' => 'terms-of-use',
                'title' => 'Terms of Use',
                'content' => '<h3>1. Conference Conduct</h3><p>Attendees must behave professionally and respectfully during all scientific sessions, networking panels, and coffee breaks.</p><h3>2. Intellectual Property</h3><p>All presented abstracts, presentation slides, and papers remain the intellectual property of their respective authors. Unauthorized recording or duplication is prohibited.</p>'
            ]
        ];
        foreach ($policies as $policy) {
            $pageContent = new PageContent();
            $pageContent->setSlug($policy['slug']);
            $pageContent->setTitle($policy['title']);
            $pageContent->setContent($policy['content']);
            $this->entityManager->persist($pageContent);
        }

        // 6. Injeção de Dados: CommitteeMember
        $io->section('Seeding CommitteeMembers...');
        $members = [
            // Brazil
            [
                'name' => 'Juliano Ayres',
                'role' => 'Chair',
                'institution' => 'Fundecitrus',
                'bio' => 'Organizing & Scientific Committee Chair for Brazil.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Brazil',
                'imageFile' => 'committee-juliano-ayres.webp'
            ],
            [
                'name' => 'Renato Bassanezi',
                'role' => 'Member',
                'institution' => 'Fundecitrus',
                'bio' => 'Organizing & Scientific Committee Member for Brazil.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Brazil',
                'imageFile' => 'committee-renato-bassanezi.jpg'
            ],
            [
                'name' => 'Franklin Behlau',
                'role' => 'Member',
                'institution' => 'Fundecitrus',
                'bio' => 'Organizing & Scientific Committee Member for Brazil.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Brazil',
                'imageFile' => 'committee-franklin-behlau.webp'
            ],
            [
                'name' => 'Silvio Lopes',
                'role' => 'Member',
                'institution' => 'Fundecitrus',
                'bio' => 'Organizing & Scientific Committee Member for Brazil.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Brazil',
                'imageFile' => 'committee-silvio-lopes.jpg'
            ],
            [
                'name' => 'Juliana de Freitas Astúa',
                'role' => 'Member (to be confirmed)',
                'institution' => 'Embrapa Cassava & Fruits',
                'bio' => 'Organizing & Scientific Committee Member for Brazil.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Brazil',
                'imageFile' => 'committee-juliana-astua.jpg'
            ],
            [
                'name' => 'Dirceu de Mattos Junior',
                'role' => 'Member',
                'institution' => 'Agronomic Institute of Campinas (IAC)',
                'bio' => 'Organizing & Scientific Committee Member for Brazil.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Brazil',
                'imageFile' => 'committee-dirceu-mattos.jpeg'
            ],
            [
                'name' => 'Lilian Amorim',
                'role' => 'Member',
                'institution' => 'University of São Paulo (USP)',
                'bio' => 'Organizing & Scientific Committee Member for Brazil.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Brazil',
                'imageFile' => 'committee-lilian-amorim.webp'
            ],
            // Florida, USA
            [
                'name' => 'Jim Graham',
                'role' => 'Member',
                'institution' => 'University of Florida, IFAS',
                'bio' => 'Organizing & Scientific Committee Member representing Florida, USA.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Florida, USA',
                'imageFile' => 'committee-jim-graham.jpeg'
            ],
            [
                'name' => 'Michael Rogers',
                'role' => 'Member',
                'institution' => 'University of Florida, IFAS',
                'bio' => 'Organizing & Scientific Committee Member representing Florida, USA.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Florida, USA',
                'imageFile' => 'committee-michael-rogers.jpg'
            ],
            // Texas, USA
            [
                'name' => 'Mamoudou Setamou',
                'role' => 'Member',
                'institution' => 'Texas A&M University',
                'bio' => 'Organizing & Scientific Committee Member representing Texas, USA.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Texas, USA',
                'imageFile' => 'committee-mamoudou-setamou.png'
            ],
            // California, USA
            [
                'name' => 'MaryLou Polek',
                'role' => 'Chair',
                'institution' => 'California',
                'bio' => 'Organizing & Scientific Committee Chair representing California, USA.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'California, USA',
                'imageFile' => 'avatar-placeholder-2.jpg'
            ],
            [
                'name' => 'Georgios Vidalakis',
                'role' => 'Member',
                'institution' => 'University of California, Riverside',
                'bio' => 'Organizing & Scientific Committee Member representing California, USA.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'California, USA',
                'imageFile' => 'committee-georgios-vidalakis.jpeg'
            ],
            [
                'name' => 'Robert Krueger',
                'role' => 'Member',
                'institution' => 'USDA Agricultural Research Service (ARS)',
                'bio' => 'National Clonal Germplasm Repository for Citrus and Dates, Riverside.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'California, USA',
                'imageFile' => 'committee-robert-krueger.avif'
            ],
            // USDA APHIS
            [
                'name' => 'Dave Bartels',
                'role' => 'Member',
                'institution' => 'USDA Animal and Plant Health Inspection Service (APHIS)',
                'bio' => 'Organizing & Scientific Committee Member representing USDA APHIS.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'USDA APHIS',
                'imageFile' => 'committee-dave-bartels.jpeg'
            ],
            [
                'name' => 'Donald Seaver',
                'role' => 'Member',
                'institution' => 'USDA Animal and Plant Health Inspection Service (APHIS)',
                'bio' => 'Organizing & Scientific Committee Member representing USDA APHIS.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'USDA APHIS',
                'imageFile' => 'avatar-placeholder.jpg'
            ],
            // China
            [
                'name' => 'Changyong Zhou',
                'role' => 'Member',
                'institution' => 'Citrus Research Institute',
                'bio' => 'Organizing & Scientific Committee Member representing China.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'China',
                'imageFile' => 'committee-changyong-zhou.jpeg'
            ],
            [
                'name' => 'Xuefeng Wang',
                'role' => 'Member',
                'institution' => 'Citrus Research Institute (CAAS / SWU)',
                'bio' => 'Deputy Director, CAAS and Southwest University (SWU).',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'China',
                'imageFile' => 'committee-xuefeng-wang.jpeg'
            ],
            // South Africa
            [
                'name' => 'Hano Maree',
                'role' => 'Member',
                'institution' => 'Citrus Research International & Stellenbosch University',
                'bio' => 'Organizing & Scientific Committee Member representing South Africa.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'South Africa',
                'imageFile' => 'committee-hano-maree.webp'
            ],
            // Argentina
            [
                'name' => 'Beatriz Stein',
                'role' => 'Member (Retired)',
                'institution' => 'Obispo Colombres Agroindustrial Experimental Station (EEAOC)',
                'bio' => 'Organizing & Scientific Committee Member representing Argentina.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Argentina',
                'imageFile' => 'committee-beatriz-stein.jpeg'
            ],
            // Costa Rica
            [
                'name' => 'Juan Delgado Fernandez',
                'role' => 'Member',
                'institution' => 'LIFE-RID / Agricenter / AMVAC',
                'bio' => 'Organizing & Scientific Committee Member representing Costa Rica.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Costa Rica',
                'imageFile' => 'committee-juan-delgado.jpeg'
            ],
            // Spain
            [
                'name' => 'Leandro Peña',
                'role' => 'Member',
                'institution' => 'Spain Research Complex',
                'bio' => 'Organizing & Scientific Committee Member representing Spain.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Spain',
                'imageFile' => 'committee-leandro-pena.jpg'
            ],
            // Australia
            [
                'name' => 'Nerida Donovan',
                'role' => 'Member',
                'institution' => 'Department of Primary Industries',
                'bio' => 'Organizing & Scientific Committee Member representing Australia.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Australia',
                'imageFile' => 'committee-nerida-donovan.jpeg'
            ],
            // Mexico
            [
                'name' => 'Carolina Ramirez',
                'role' => 'Member',
                'institution' => 'Mexico Agricultural Research',
                'bio' => 'Organizing & Scientific Committee Member representing Mexico.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Mexico',
                'imageFile' => 'avatar-placeholder-2.jpg'
            ],
            // Scientific Advisor
            [
                'name' => 'Tim Gottwald',
                'role' => 'Scientific Advisor (Retired)',
                'institution' => 'USDA Agricultural Research Service (ARS)',
                'bio' => 'Lead Scientific Advisor representing USDA ARS.',
                'academicLink' => null,
                'linkedinUrl' => null,
                'groupType' => 'Scientific Advisor',
                'imageFile' => 'committee-tim-gottwald.webp'
            ]
        ];

        foreach ($members as $idx => $m) {
            $member = new CommitteeMember();
            $member->setName($m['name']);
            $member->setRole($m['role']);
            $member->setInstitution($m['institution']);
            $member->setBio($m['bio']);
            $member->setAcademicLink($m['academicLink']);
            $member->setLinkedinUrl($m['linkedinUrl']);
            $member->setGroupType($m['groupType']);
            $member->setPosition($idx + 1);
            
            $imgObj = $uploadImage($layoutImagesDir . '/' . $m['imageFile'], 'committee');
            if ($imgObj) {
                $member->setImage($imgObj);
            }
            $this->entityManager->persist($member);
        }

        // 7. Injeção de Dados: RegistrationBatch (Lotes)
        $io->section('Seeding RegistrationBatches...');
        $batches = [
            ['name' => 'Early-Bird Tariff', 'days' => 60, 'price' => '300.00', 'pos' => 1],
            ['name' => 'Regular Tariff', 'days' => 120, 'price' => '450.00', 'pos' => 2],
            ['name' => 'Late / On-site Tariff', 'days' => 180, 'price' => '600.00', 'pos' => 3]
        ];
        foreach ($batches as $b) {
            $batch = new RegistrationBatch();
            $batch->setName($b['name']);
            $batch->setStartDate(new \DateTime());
            $batch->setEndDate((new \DateTime())->modify("+{$b['days']} days"));
            $batch->setPosition($b['pos']);
            $batch->setPrice($b['price']);
            $this->entityManager->persist($batch);
        }

        // 8. Injeção de Dados: ThematicGroup (Cronograma Crítico / Call for Papers)
        $io->section('Seeding ThematicGroups (Critical Timeline)...');
        $groups = [
            ['title' => 'Call for Papers Opens', 'desc' => 'Submission portal opens online via Fealq integration.', 'days' => 30],
            ['title' => 'Submission Deadline', 'desc' => 'Final call for all abstracts and full papers under peer review.', 'days' => 90],
            ['title' => 'Acceptance Notification', 'desc' => 'Scientific board releases the final review decisions to authors.', 'days' => 120]
        ];
        foreach ($groups as $g) {
            $group = new ThematicGroup();
            $group->setTitle($g['title']);
            $group->setDescription($g['desc']);
            $group->setEventDate((new \DateTime())->modify("+{$g['days']} days"));
            $this->entityManager->persist($group);
        }

        // 9. Injeção de Dados: SponsorshipTier
        $io->section('Seeding SponsorshipTiers...');
        $tiers = [
            ['name' => 'Diamond Sponsors', 'pos' => 1],
            ['name' => 'Silver Sponsors', 'pos' => 2],
            ['name' => 'Institutional Support', 'pos' => 3]
        ];
        $tierObjects = [];
        foreach ($tiers as $t) {
            $tier = new SponsorshipTier();
            $tier->setName($t['name']);
            $tier->setPosition($t['pos']);
            $this->entityManager->persist($tier);
            $tierObjects[$t['name']] = $tier;
        }

        // 10. Injeção de Dados: Sponsor
        $io->section('Seeding Sponsors...');
        $sponsors = [
            ['name' => 'Cutrale', 'tier' => 'Diamond Sponsors', 'logo' => 'cutraleLogo.png', 'url' => 'https://www.cutrale.com.br', 'isEx' => true, 'pos' => 1],
            ['name' => 'Citrosuco', 'tier' => 'Diamond Sponsors', 'logo' => 'logo-citro-suco.png', 'url' => 'https://www.citrosuco.com.br', 'isEx' => true, 'pos' => 2],
            ['name' => 'Conab', 'tier' => 'Silver Sponsors', 'logo' => 'logo-conab.jpg', 'url' => 'https://www.conab.gov.br', 'isEx' => false, 'pos' => 3],
            ['name' => 'Credicitrus', 'tier' => 'Silver Sponsors', 'logo' => 'logo-credicitrus.jpg', 'url' => 'https://www.credicitrus.com.br', 'isEx' => true, 'pos' => 4],
            ['name' => 'Fundecitrus', 'tier' => 'Institutional Support', 'logo' => 'fundecitrus_logo_menu.webp', 'url' => 'https://www.fundecitrus.com.br', 'isEx' => false, 'pos' => 5],
            ['name' => 'WAB Admin', 'tier' => 'Institutional Support', 'logo' => 'logo.png', 'url' => 'https://atlassian.com', 'isEx' => false, 'pos' => 6]
        ];
        foreach ($sponsors as $s) {
            $sponsor = new Sponsor();
            $sponsor->setName($s['name']);
            $sponsor->setWebsiteUrl($s['url']);
            $sponsor->setTier($tierObjects[$s['tier']]);
            $sponsor->setIsExhibitor($s['isEx']);
            $sponsor->setPosition($s['pos']);
            $sponsor->setDescription("Official partner dedicated to driving tech integration in agribusiness.");
            $sponsor->setStandNumber($s['isEx'] ? 'Stand ' . rand(1, 20) : null);
            
            // Procura nos logos
            $logoPath = $logosImagesDir . '/' . $s['logo'];
            if (!file_exists($logoPath)) {
                $logoPath = $layoutImagesDir . '/' . $s['logo']; // Fallback
            }
            $logoImgObj = $uploadImage($logoPath, 'sponsor');
            if ($logoImgObj) {
                $sponsor->setLogo($logoImgObj);
            }
            $this->entityManager->persist($sponsor);
        }

        // 10.1. Injeção de Dados: Organizer
        $io->section('Seeding Organizers...');
        $organizerLogosDir = $this->projectDir . '/seed-data/logos';
        $organizers = [
            [
                'name' => 'Fundecitrus',
                'logo' => 'Fundecitrus.webp',
                'url' => 'https://www.fundecitrus.com.br',
                'pos' => 1
            ],
            [
                'name' => 'Embrapa',
                'logo' => 'Embrapa.png',
                'url' => 'https://www.embrapa.br',
                'pos' => 2
            ],
            [
                'name' => 'Luiz de Queiroz College of Agriculture (ESALQ/USP)',
                'logo' => 'Luiz de Queiroz College of Agriculture (ESALQ:USP) .png',
                'url' => 'https://www.esalq.usp.br',
                'pos' => 3
            ],
            [
                'name' => 'Sylvio Moreira Citrus Center – Agronomic Institute (IAC)',
                'logo' => 'Sylvio Moreira Citrus Center – Agronomic Institute (IAC) .jpeg',
                'url' => 'http://www.ccsm.br',
                'pos' => 4
            ]
        ];

        foreach ($organizers as $org) {
            $organizer = new Organizer();
            $organizer->setName($org['name']);
            $organizer->setWebsiteUrl($org['url']);
            $organizer->setPosition($org['pos']);

            $logoPath = $organizerLogosDir . '/' . $org['logo'];
            $logoImg = $uploadImage($logoPath, 'organizer');
            if ($logoImg) {
                $organizer->setLogo($logoImg);
            }
            $this->entityManager->persist($organizer);
        }

        // 11. Injeção de Dados: SponsorshipInquiry
        $io->section('Seeding SponsorshipInquiries...');
        for ($i = 1; $i <= 5; $i++) {
            $inquiry = new SponsorshipInquiry();
            $inquiry->setCompanyName("AgroCorp #{$i}");
            $inquiry->setContactPerson("Manager #{$i}");
            $inquiry->setCorporateEmail("contact@agrocorp{$i}.com");
            $inquiry->setInterestArea("Diamond Quota");
            $inquiry->setStatus('New');
            $this->entityManager->persist($inquiry);
        }

        // 12. Injeção de Dados: AirportGuide
        $io->section('Seeding AirportGuides...');
        $airports = [
            ['name' => 'Dr. Leite Lopes State Airport (RAO)', 'code' => 'RAO Hub', 'dist' => '12 km (7.5 miles)', 'trans' => 'Taxis, ride-hailing services (Uber and 99), and private shuttle services (15–25 mins).', 'img' => 'airport-rao.jpg', 'pos' => 1],
            ['name' => 'Guarulhos Int. Airport', 'code' => 'GRU Hub', 'dist' => '310 km (193 miles)', 'trans' => 'Connecting flights to RAO or car transport via modern highway system.', 'img' => 'airport-gru.jpg', 'pos' => 2],
            ['name' => 'Viracopos Int. Airport', 'code' => 'VCP Hub', 'dist' => '220 km (137 miles)', 'trans' => 'Intercity bus service (Cometa) or road travel via Anhanguera Highway.', 'img' => 'airport-vcp.jpg', 'pos' => 3]
        ];
        foreach ($airports as $a) {
            $guide = new AirportGuide();
            $guide->setName($a['name']);
            $guide->setCode($a['code']);
            $guide->setDistance($a['dist']);
            $guide->setTransport($a['trans']);
            $guide->setDescription("Essential airport guide for all international and domestic delegations.");
            $guide->setPosition($a['pos']);
            
            $imgObj = $uploadImage($layoutImagesDir . '/' . $a['img'], 'airport');
            if ($imgObj) {
                $guide->setImage($imgObj);
            }
            $this->entityManager->persist($guide);
        }

        // 13. Injeção de Dados: PartnerHotel
        $io->section('Seeding PartnerHotels...');
        $hotels = [
            ['name' => 'Mont Blanc Premium', 'stars' => 5, 'category' => 'Premium Hotel', 'distance' => '2.3 km', 'code' => null, 'link' => 'https://www.montblancpremium.com.br', 'img' => 'hotel-montblanc.webp', 'pos' => 1],
            ['name' => 'Hotel Araucária Plaza', 'stars' => 5, 'category' => 'Premium Hotel', 'distance' => '2.6 km', 'code' => null, 'link' => 'http://www.araucariaplaza.com.br', 'img' => 'hotel-araucaria.webp', 'pos' => 2],
            ['name' => 'TRYP by Wyndham Ribeirão Preto', 'stars' => 4, 'category' => 'International Business Hotel', 'distance' => '700 m', 'code' => 'IRCHLB27', 'link' => null, 'img' => 'hotel-tryp.webp', 'pos' => 3],
            ['name' => 'Wyndham Garden Ribeirão Preto Convention', 'stars' => 4, 'category' => 'International Business Hotel', 'distance' => '1.8 km', 'code' => 'IRCHLB27', 'link' => null, 'img' => 'hotel-wyndham.webp', 'pos' => 4],
            ['name' => 'ibis Ribeirão Preto Shopping', 'stars' => 3, 'category' => 'Best Location (connected to RibeirãoShopping)', 'distance' => '200 m', 'code' => 'IRCHLB27', 'link' => null, 'img' => 'hotel-ibis.webp', 'pos' => 5],
            ['name' => 'Matiz Vilaboim Ribeirão Preto', 'stars' => 3, 'category' => 'Best Value for Money', 'distance' => '1.2 km', 'code' => 'IRCHLB27', 'link' => null, 'img' => 'hotel-matiz.webp', 'pos' => 6]
        ];
        foreach ($hotels as $h) {
            $hotel = new PartnerHotel();
            $hotel->setName($h['name']);
            $hotel->setStars($h['stars']);
            $hotel->setBookingCode($h['code']);
            $hotel->setBookingLink($h['link']);
            $hotel->setDescription($h['category']);
            $hotel->setAddress($h['distance']);
            $hotel->setContact("+55 (16) " . rand(3000, 9999) . "-" . rand(1000, 9999));
            $hotel->setPosition($h['pos']);
            
            $imgObj = $uploadImage($layoutImagesDir . '/' . $h['img'], 'hotel');
            if ($imgObj) {
                $hotel->setImage($imgObj);
            }
            $this->entityManager->persist($hotel);
        }

        // 14. Injeção de Dados: RestaurantRecommendation
        $io->section('Seeding RestaurantRecommendations...');
        $restaurants = [
            ['name' => 'Jangada', 'price' => '$$$', 'cat' => 'Seafood & Premium Meats', 'desc' => 'Fresh seafood, fish, and premium meat dishes.', 'img' => 'dining-jangada.webp', 'map' => 'https://www.google.com/maps/search/?api=1&query=Jangada+RibeiraoShopping', 'pos' => 1],
            ['name' => 'Cabaña RibeirãoShopping', 'price' => '$$$$', 'cat' => 'Argentine Steakhouse', 'desc' => 'Premium Argentine steaks.', 'img' => 'dining-cabana.webp', 'map' => 'https://www.google.com/maps/search/?api=1&query=Cabana+RibeiraoShopping', 'pos' => 2],
            ['name' => 'Pinguim', 'price' => '$$', 'cat' => 'Traditional & Cultural Icon', 'desc' => 'One of Ribeirão Preto\'s most iconic restaurants, renowned for its traditional draft beer ("chopp").', 'img' => 'dining-pinguim.webp', 'map' => 'https://www.google.com/maps/search/?api=1&query=Pinguim+RibeiraoShopping', 'pos' => 3],
            ['name' => 'Bar do Nelson', 'price' => '$$', 'cat' => 'Traditional Brazilian', 'desc' => 'Traditional Brazilian cuisine, famous for its parmegiana specialties.', 'img' => 'dining-barnelson.webp', 'map' => 'https://www.google.com/maps/search/?api=1&query=Bar+do+Nelson+Ribeirao+Preto', 'pos' => 4],
            ['name' => 'Outback Steakhouse', 'price' => '$$$', 'cat' => 'Steakhouse & Bar', 'desc' => 'Australian-inspired international cuisine.', 'img' => 'dining-outback.webp', 'map' => 'https://www.google.com/maps/search/?api=1&query=Outback+Steakhouse+RibeiraoShopping', 'pos' => 5],
            ['name' => 'Madero Steak House', 'price' => '$$$', 'cat' => 'Burgers & Grill', 'desc' => 'Gourmet burgers and grilled meats.', 'img' => 'dining-madero.webp', 'map' => 'https://www.google.com/maps/search/?api=1&query=Madero+Steak+House+RibeiraoShopping', 'pos' => 6],
            ['name' => 'Mirai Japanese Restaurant', 'price' => '$$$', 'cat' => 'Japanese Cuisine', 'desc' => 'Authentic Japanese cuisine.', 'img' => 'dining-mirai.webp', 'map' => 'https://www.google.com/maps/search/?api=1&query=Mirai+Japanese+Restaurant+RibeiraoShopping', 'pos' => 7],
            ['name' => 'Ancho Di Tullio', 'price' => '$$$$', 'cat' => 'Argentine Parrilla', 'desc' => 'Premium steaks grilled over a traditional Argentine parrilla.', 'img' => 'dining-ancho.webp', 'map' => 'https://www.google.com/maps/search/?api=1&query=Ancho+Di+Tullio+RibeiraoShopping', 'pos' => 8]
        ];
        foreach ($restaurants as $r) {
            $rest = new RestaurantRecommendation();
            $rest->setName($r['name']);
            $rest->setPriceRange($r['price']);
            $rest->setCategory($r['cat']);
            $rest->setDescription($r['desc']);
            $rest->setLocationUrl($r['map']);
            $rest->setPosition($r['pos']);
            
            $imgObj = $uploadImage($layoutImagesDir . '/' . $r['img'], 'dining');
            if ($imgObj) {
                $rest->setImage($imgObj);
            }
            $this->entityManager->persist($rest);
        }

        // 15. Injeção de Dados: ContactMessage
        $io->section('Seeding ContactMessages...');
        for ($i = 1; $i <= 5; $i++) {
            $msg = new ContactMessage();
            $msg->setFirstName("Congressist");
            $msg->setLastName("#{$i}");
            $msg->setEmail("congressist{$i}@domain.com");
            $msg->setSubject("General Information");
            $msg->setMessage("Hello, I would like to inquire about certificates and translation services.");
            $msg->setConsent(true);
            $msg->setStatus('New');
            $this->entityManager->persist($msg);
        }

        // 16. Injeção de Dados: FAQ
        $io->section('Seeding FaqCategories and FaqItems...');
        $faqCats = ['Registration', 'Submissions', 'General'];
        $faqCatObjs = [];
        foreach ($faqCats as $idx => $name) {
            $cat = new FaqCategory();
            $cat->setName($name);
            $cat->setPosition($idx + 1);
            $this->entityManager->persist($cat);
            $faqCatObjs[$name] = $cat;
        }

        $faqs = [
            ['q' => 'How are paper submissions handled?', 'a' => 'Paper submissions are processed externally through the Fealq network.', 'cat' => 'Submissions'],
            ['q' => 'What is the refund policy?', 'a' => 'Cancellations must adhere to our rigorous 7-day policy limit post-purchase.', 'cat' => 'Registration'],
            ['q' => 'Will certificates be available?', 'a' => 'Yes, digital certificates of attendance will be available 48 hours post-event.', 'cat' => 'General']
        ];
        foreach ($faqs as $idx => $f) {
            $item = new FaqItem();
            $item->setQuestion($f['q']);
            $item->setAnswer($f['a']);
            $item->setCategory($faqCatObjs[$f['cat']]);
            $item->setPosition($idx + 1);
            $item->setIsActive(true);
            $this->entityManager->persist($item);
        }

        // 17. Injeção em Lote: EventDays (Dias do Evento)
        $io->section('Seeding EventDays...');
        $dayObjs = [];
        for ($i = 1; $i <= 4; $i++) {
            $day = new EventDay();
            $day->setDate((new \DateTime())->modify("+{$i} days"));
            $day->setTitle("Day {$i}: " . (new \DateTime())->modify("+{$i} days")->format('D, M d'));
            $day->setPosition($i);
            $this->entityManager->persist($day);
            $dayObjs[] = $day;
        }

        // 18. Injeção em Lote: VenueRooms (Salas e Auditórios)
        $io->section('Seeding VenueRooms...');
        $roomNames = ['Auditorium A', 'Symposium Room B', 'Auditorium C'];
        $roomObjs = [];
        foreach ($roomNames as $name) {
            $room = new VenueRoom();
            $room->setName($name);
            $room->setCapacity(rand(100, 300));
            $this->entityManager->persist($room);
            $roomObjs[] = $room;
        }

        // 19. Injeção em Lote: Speakers (50 Congressistas / Palestrantes)
        $io->section('Seeding 50 Speakers & detailed profiles...');
        $speakerObjs = [];

        // 10 Palestrantes ricos/completos
        $richSpeakers = [
            ['name' => 'Dr. Alice Vance', 'inst' => 'University of Florida (UFL)', 'dept' => 'Department of Plant Pathology', 'img' => 'speaker1.jpg'],
            ['name' => 'Dr. Marcos Silva', 'inst' => 'Fundecitrus', 'dept' => 'Department of Vector Dynamics', 'img' => 'speaker2.jpg'],
            ['name' => 'Prof. Li Wei', 'inst' => 'Guangdong Academy of Agricultural Sciences', 'dept' => 'Biotechnology Center', 'img' => 'speaker3.jpg'],
            ['name' => 'Dr. Arthur Pendragon', 'inst' => 'Fundecitrus', 'dept' => 'Agronomy Board', 'img' => 'speaker2.jpg'],
            ['name' => 'Dr. Elena Rostova', 'inst' => 'University of São Paulo (USP)', 'dept' => 'Plant Pathology Dept', 'img' => 'speaker1.jpg'],
            ['name' => 'Dr. Kenji Sato', 'inst' => 'IRCHLB Foundation', 'dept' => 'Vector Mapping Lab', 'img' => 'speaker3.jpg'],
            ['name' => 'Dr. Sarah Lee', 'inst' => 'Florida Citrus Department', 'dept' => 'Logistics Board', 'img' => 'avatar-placeholder.jpg'],
            ['name' => 'Dr. Marcus Vinicius', 'inst' => 'Embrapa', 'dept' => 'Citriculture Department', 'img' => 'avatar-placeholder-2.jpg'],
            ['name' => 'Dr. Helena Costa', 'inst' => 'Citrus BR', 'dept' => 'Sponsorships Board', 'img' => 'speaker1.jpg'],
            ['name' => 'Prof. Donald Miller', 'inst' => 'University of California', 'dept' => 'Department of Entomology', 'img' => 'speaker3.jpg']
        ];

        foreach ($richSpeakers as $idx => $rs) {
            $speaker = new Speaker();
            $speaker->setName($rs['name']);
            $speaker->setInstitution($rs['inst']);
            $speaker->setDepartment($rs['dept']);
            $speaker->setShortBio("Leading expert and international speaker focused on pathogenetic citrus greening strategies.");
            $speaker->setBio("<p>{$rs['name']} is a leading researcher at the {$rs['inst']}. Over the last ten years, their lab has successfully evaluated symbiotic bacterial therapies and transgenic citrus arrays against Huanglongbing (HLB).</p><p>Serving on multiple international boards, they bridge growers' realities with biotechnology breakthroughs.</p>");
            $speaker->setLinkedinUrl('https://linkedin.com');
            $speaker->setInstagramUrl('https://instagram.com');
            $speaker->setFacebookUrl('https://facebook.com');
            $speaker->setYoutubeUrl('https://youtube.com');
            $speaker->setWhatsappUrl('+5516999999999');
            $speaker->setScholarUrl('https://scholar.google.com');
            $speaker->setLattesUrl('http://lattes.cnpq.br');
            $speaker->setResearchAreas(['Antimicrobial Peptides', 'Transgenic Citrus Arrays', 'Vector Management']);
            $speaker->setIsFeatured(true);
            $speaker->setPosition($idx + 1);

            $imgObj = $uploadImage($layoutImagesDir . '/' . $rs['img'], 'speaker');
            if ($imgObj) {
                $speaker->setImage($imgObj);
            }
            $this->entityManager->persist($speaker);
            $speakerObjs[] = $speaker;

            // Injeta 2 papers para o palestrante completo
            for ($p = 1; $p <= 2; $p++) {
                $paper = new SpeakerPaper();
                $paper->setTitle("Efficacy of AMP-driven Symbiotic Bacteria in Field Scenarios (Trial #{$p})");
                $paper->setCallDetails("Co-authored with Dr. Marcos Silva • Abstract ID: " . rand(1000, 9999) . "-A");
                $paper->setSpeaker($speaker);
                
                $pdfImg = $uploadImage($layoutImagesDir . '/conference-room.jpg', 'abstract_pdf'); // Mockup do PDF
                if ($pdfImg) {
                    $paper->setPdfFile($pdfImg);
                }
                $this->entityManager->persist($paper);
            }

            // Injeta 2 itens de agenda pessoal
            for ($a = 1; $a <= 2; $a++) {
                $personalAgenda = new SpeakerAgenda();
                $personalAgenda->setEventDateText("Day " . $a . ": Mon, Oct 26");
                $personalAgenda->setTitle($a === 1 ? 'Opening Plenary Session' : 'Technical Panel: Vector Control');
                $personalAgenda->setTimeLocationText("0" . ($a + 7) . ":00 AM - Auditorium " . ($a === 1 ? 'A' : 'C'));
                $personalAgenda->setSpeaker($speaker);
                $this->entityManager->persist($personalAgenda);
            }
        }

        // Injeta 40 palestrantes simplificados adicionais
        for ($i = 11; $i <= 50; $i++) {
            $speaker = new Speaker();
            $speaker->setName("Dr. Researcher #{$i}");
            $speaker->setInstitution("Citrus University #{$i}");
            $speaker->setDepartment("Faculty of Agronomy");
            $speaker->setShortBio("Researcher contributing to the global scientific review board of HLB 2027.");
            $speaker->setBio("<p>Dr. Researcher #{$i} focuses on epidemiological mapping and vector population dynamics.</p>");
            $speaker->setIsFeatured(false);
            $speaker->setPosition($i);
            
            $imgObj = $uploadImage($layoutImagesDir . '/avatar-placeholder.jpg', 'speaker');
            if ($imgObj) {
                $speaker->setImage($imgObj);
            }
            $this->entityManager->persist($speaker);
            $speakerObjs[] = $speaker;

            // Injeta 1 paper simples
            $paper = new SpeakerPaper();
            $paper->setTitle("Epidemiological Mapping and Vector Management - Study #{$i}");
            $paper->setCallDetails("Co-authored with scientific colleagues • Abstract ID: " . rand(1000, 9999) . "-B");
            $paper->setSpeaker($speaker);
            $pdfImg = $uploadImage($layoutImagesDir . '/conference-room.jpg', 'abstract_pdf');
            if ($pdfImg) {
                $paper->setPdfFile($pdfImg);
            }
            $this->entityManager->persist($paper);
        }

        // 20. Injeção em Lote: AgendaActivity (50 atividades da agenda geral)
        $io->section('Seeding 50 AgendaActivities...');
        $activityTypes = ['Plenary Session', 'Keynote Lecture', 'Technical Panel', 'Workshop'];
        $activityTitles = [
            'Opening Ceremony & State of the Art in HLB',
            'Advances in Vector Resistance Strategies',
            'Microbial Therapy & Field Applications',
            'Regional Strategies & Grower\'s Forum',
            'Genomic Mapping of Candidatus Liberibacter',
            'Nutritional Support Programs for Symptomatic Groves',
            'Chemical Control Efficacy under High Inoculum pressure',
            'Early Vector Detection Technologies',
            'Biological Control with Tamarixia radiata',
            'Grower Panel: Surviving HLB in São Paulo State'
        ];

        $timeSlots = [
            ['start' => '08:00:00', 'end' => '09:30:00'],
            ['start' => '10:00:00', 'end' => '11:30:00'],
            ['start' => '13:30:00', 'end' => '15:00:00'],
            ['start' => '15:30:00', 'end' => '17:00:00']
        ];

        for ($i = 1; $i <= 50; $i++) {
            $activity = new AgendaActivity();
            
            // Títulos variados
            $titleIndex = ($i - 1) % count($activityTitles);
            $activity->setTitle($activityTitles[$titleIndex] . " - Part " . (ceil($i / 10)));
            $activity->setType($activityTypes[array_rand($activityTypes)]);
            
            // Atribui dia e sala de forma balanceada
            $activity->setEventDay($dayObjs[($i - 1) % count($dayObjs)]);
            $activity->setRoom($roomObjs[($i - 1) % count($roomObjs)]);
            
            // Atribui slot de hora
            $slot = $timeSlots[($i - 1) % count($timeSlots)];
            $activity->setStartTime(new \DateTime($slot['start']));
            $activity->setEndTime(new \DateTime($slot['end']));
            
            $activity->setDescription("This interactive technical session features scientific presentations followed by a dedicated Q&A panel.");

            // Associa de 1 a 3 palestrantes aleatórios do nosso pool
            $numSpeakers = rand(1, 3);
            $randomKeys = array_rand($speakerObjs, $numSpeakers);
            $keys = is_array($randomKeys) ? $randomKeys : [$randomKeys];
            foreach ($keys as $k) {
                $activity->addSpeaker($speakerObjs[$k]);
            }

            $this->entityManager->persist($activity);
        }

        $io->section('Flushing all data to MySQL...');
        $this->entityManager->flush();

        $io->success('Database successfully seeded with 50 Speakers and 50 AgendaActivities, including media attachments!');

        return Command::SUCCESS;
    }
}
