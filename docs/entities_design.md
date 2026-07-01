# Proposta de Design de Entidades e Relacionamentos - IRCHLB 2027

Este documento apresenta a modelagem de entidades do banco de dados (MySQL via Doctrine ORM) projetada com base nos layouts da área pública e nos requisitos do painel administrativo do portal do **VIII International Research Conference on Huanglongbing (IRCHLB 2027)**.

---

## 🗺️ Visão Geral dos Relacionamentos

Abaixo está o diagrama representativo das principais entidades do sistema e suas interconexões:

```mermaid
erDiagram
    EventConfig ||--o{ StatisticItem : "exibe"
    EventConfig }o--|| Image : "imagem_hero"
    EventConfig }o--|| Image : "prospecto_pdf"

    CommitteeMember }o--|| Image : "foto"

    RegistrationCategory ||--o{ RegistrationPrice : "tem_precos"
    RegistrationBatch ||--o{ RegistrationPrice : "tem_precos"
    RegistrationPrice }o--|| RegistrationCategory : "categoria"
    RegistrationPrice }o--|| RegistrationBatch : "lote"

    Speaker ||--o{ SpeakerPaper : "submeteu_n_artigos"
    Speaker ||--o{ SpeakerAgenda : "tem_n_itens_agenda"
    Speaker }o--|| Image : "headshot"
    SpeakerPaper }o--|| Image : "pdf_arquivo"

    AgendaActivity }o--|| EventDay : "ocorre_no_dia"
    AgendaActivity }o--|| VenueRoom : "ocorre_na_sala"
    AgendaActivity }o--{{ Speaker : "palestrantes_engajados_geral"

    Sponsor }o--|| SponsorshipTier : "pertence_a_cota"
    Sponsor }o--|| Image : "logo"

    AirportGuide }o--|| Image : "imagem"
    PartnerHotel }o--|| Image : "imagem"
    RestaurantRecommendation }o--|| Image : "imagem"

    FaqItem }o--|| FaqCategory : "pertence_a_categoria"
```

---

## 🗄️ Detalhamento das Entidades

### 1. Módulo Core & Configurações Globais

#### `EventConfig` (Entidade Singleton)
Armazena informações globais do congresso e do local.
*   `id` (Integer, Primary Key)
*   `title` (String, 255)
*   `subtitle` (String, 255)
*   `eventDates` (String, 100) — ex: "October 26-29, 2027"
*   `locationName` (String, 255) — ex: "Fundecitrus Convention Center"
*   `addressStreet` (String, 255)
*   `addressNeighborhood` (String, 255)
*   `addressCity` (String, 100)
*   `addressZipCode` (String, 20)
*   `googleMapsUrl` (Text)
*   `heroDescription` (Text)
*   `heroImage` (imageFile)
*   `supportEmail` (String, 180)
*   `supportPhone` (String, 50)
*   `whatsappNumber` (String, 50)
*   `linkedinUrl` (String, 255, Nullable)
*   `instagramUrl` (String, 255, Nullable)
*   `youtubeUrl` (String, 255, Nullable)
*   `prospectusFile` (imageFile)

#### `StatisticItem` (Estatísticas na Home)
*   `id` (Integer, Primary Key)
*   `label` (String, 100)
*   `value` (String, 50)
*   `position` (Integer)
*   `isActive` (Boolean)

#### `PageContent` (CMS para Páginas Extras)
Focado no cadastro e exibição de páginas institucionais dinâmicas extras (como "Políticas de privacidade", "Termos de uso", etc.).
*   `id` (Integer, Primary Key)
*   `slug` (String, 100, Unique) — ex: "politicas-de-privacidade", "termos-de-uso"
*   `title` (String, 255)
*   `content` (Text) — Conteúdo em HTML para texto formatado
*   `updatedAt` (DateTime)

#### `CommitteeMember` (Comissão Organizadora)
*   `id` (Integer, Primary Key)
*   `name` (String, 255)
*   `image` (imageFile)
*   `role` (String, 255)
*   `institution` (String, 255)
*   `bio` (Text)
*   `academicLink` (String, 255, Nullable)
*   `linkedinUrl` (String, 255, Nullable) — Link para o perfil profissional no LinkedIn
*   `groupType` (String, 100)
*   `position` (Integer)

---

### 2. Módulo Dados da Inscrição
ion` (Integer)

#### `RegistrationBatch` (Lotes / Cronograma Tarifário)
*   `id` (Integer, Primary Key)
*   `name` (String, 100) — ex: "Early-Bird", "Regular", "Late / On-site"
*   `startDate` (DateTime, Nullable)
*   `endDate` (DateTime, Nullable)
*   `position` (Integer)
*   `price` (Decimal, 10,2)

---

### 3. Cronograma Crítico

#### `ThematicGroup` (Grupos Temáticos do Call for Papers)
*   `id` (Integer, Primary Key)
*   `title` (String, 255) — ex: "Submission Deadline"
*   `description` (Text, Nullable)
*   `eventDate` (Date)


---

### 4. Módulo Agenda & Palestrantes / Congressistas com Perfil

#### `Speaker` (Congressistas com Perfil Público / Palestrantes)
Entidade que representa os palestrantes e cientistas que expõem trabalhos no site.
*   `id` (Integer, Primary Key)
*   `name` (String, 255)
*   `image` (ImageFile)
*   `institution` (String, 255)
*   `department` (String, 255, Nullable)
*   `shortBio` (String, 255) — Biografia resumida para a listagem
*   `bio` (Text) — Textarea com suporte a HTML (Rich Text) para a biografia
*   `linkedinUrl` (String, 255, Nullable)
*   `instagramUrl` (String, 255, Nullable)
*   `facebookUrl` (String, 255, Nullable)
*   `youtubeUrl` (String, 255, Nullable)
*   `whatsappUrl` (String, 255, Nullable) — Link ou número de suporte direto via WhatsApp
*   `scholarUrl` (String, 255, Nullable)
*   `lattesUrl` (String, 255, Nullable)
*   `researchAreas` (Json) — Armazena a lista de textos ("Key Research Areas")
*   `isFeatured` (Boolean)
*   `position` (Integer)
*   `papers` (OneToMany -> `SpeakerPaper`, mappedBy: "speaker") — N documentos vinculados
*   `personalAgendas` (OneToMany -> `SpeakerAgenda`, mappedBy: "speaker") — N itens de agenda vinculados

#### `SpeakerPaper` (Artigos/Trabalhos Submetidos pelo Congressista)
Mapeia a lista de "Submitted Papers & Abstracts" do congressista.
*   `id` (Integer, Primary Key)
*   `title` (String, 255) — Título do Artigo (ex: "Efficacy of AMP-driven Symbiotic Bacteria in Field Scenarios")
*   `callDetails` (String, 255) — Detalhes da chamada/Co-autores/ID do abstract (ex: "Co-authored with Dr. Marcos Silva • Abstract ID: 2994-A")
*   `pdfFile` (imageFile) — Arquivo PDF do artigo/abstract para download
*   `speaker` (ManyToOne -> `Speaker`)

#### `SpeakerAgenda` (Itens de Agenda Pessoal / "Conference Agenda")
Mapeia a listagem de atividades da timeline na barra lateral do perfil do congressista.
*   `id` (Integer, Primary Key)
*   `eventDateText` (String, 100) — Texto da data para o badge superior (ex: "Mon, Mar 22")
*   `title` (String, 255) — Título da atividade na timeline (ex: "Opening Plenary")
*   `timeLocationText` (String, 150) — Texto do horário e local (ex: "08:00 AM - Auditorium A")
*   `speaker` (ManyToOne -> `Speaker`)

#### `EventDay` (Dias de Evento na Agenda Geral)
*   `id` (Integer, Primary Key)
*   `date` (Date)
*   `title` (String, 100)
*   `position` (Integer)

#### `VenueRoom` (Auditórios e Salas)
*   `id` (Integer, Primary Key)
*   `name` (String, 255)
*   `capacity` (Integer, Nullable)

#### `AgendaActivity` (Grade Geral da Agenda)
*   `id` (Integer, Primary Key)
*   `title` (String, 255)
*   `type` (String, 100)
*   `eventDay` (ManyToOne -> `EventDay`)
*   `startTime` (Time)
*   `endTime` (Time)
*   `room` (ManyToOne -> `VenueRoom`, Nullable)
*   `description` (Text, Nullable)
*   `speakers` (ManyToMany -> `Speaker`)

---

### 5. Módulo Patrocinadores & Expositores

#### `SponsorshipTier` (Níveis de Patrocínio)
*   `id` (Integer, Primary Key)
*   `name` (String, 100)
*   `position` (Integer)

#### `Sponsor` (Patrocinadores e Stands)
*   `id` (Integer, Primary Key)
*   `name` (String, 255)
*   `logo` (ImageFile)
*   `websiteUrl` (String, 255, Nullable)
*   `tier` (ManyToOne -> `SponsorshipTier`)
*   `description` (Text, Nullable)
*   `standNumber` (String, 50, Nullable)
*   `isExhibitor` (Boolean)
*   `position` (Integer)

#### `SponsorshipInquiry` (Interesse em Patrocínio)
*   `id` (Integer, Primary Key)
*   `companyName` (String, 255)
*   `contactPerson` (String, 255)
*   `corporateEmail` (String, 180)
*   `interestArea` (String, 100)
*   `createdAt` (DateTime)
*   `status` (String, 50)

---

### 6. Módulo Guia Prático Local

#### `AirportGuide` (Aeroportos)
*   `id` (Integer, Primary Key)
*   `name` (String, 255)
*   `code` (String, 50)
*   `image` (imageFile)
*   `description` (Text)
*   `distance` (String, 100) — ex: "8 km"
*   `transport` (String, 255)
*   `position` (Integer)

#### `PartnerHotel` (Hotéis Parceiros)
*   `id` (Integer, Primary Key)
*   `name` (String, 255)
*   `stars` (Integer)
*   `image` (imageFile)
*   `description` (Text)
*   `bookingCode` (String, 50, Nullable) — Código promocional (ex: "IRCHLB27")
*   `bookingLink` (String, 255, Nullable)
*   `address` (String, 255, Nullable)
*   `contact` (String, 100, Nullable)
*   `position` (Integer)

#### `RestaurantRecommendation` (Dicas Gastronômicas)
*   `id` (Integer, Primary Key)
*   `name` (String, 255)
*   `priceRange` (String, 10)
*   `category` (String, 100)
*   `description` (Text)
*   `image` (imageFile)
*   `locationUrl` (String, 255, Nullable)
*   `position` (Integer)

---

### 7. Módulo Contato & Dúvidas

#### `ContactMessage` (Formulário Geral de Contato)
*   `id` (Integer, Primary Key)
*   `firstName` (String, 100)
*   `lastName` (String, 100)
*   `email` (String, 180)
*   `subject` (String, 100)
*   `message` (Text)
*   `consent` (Boolean)
*   `createdAt` (DateTime)
*   `status` (String, 50)

#### `FaqCategory` (Categorias do FAQ)
*   `id` (Integer, Primary Key)
*   `name` (String, 100)
*   `position` (Integer)

#### `FaqItem` (Perguntas e Respostas)
*   `id` (Integer, Primary Key)
*   `question` (String, 255)
*   `answer` (Text)
*   `category` (ManyToOne -> `FaqCategory`)
*   `position` (Integer)
*   `isActive` (Boolean)
