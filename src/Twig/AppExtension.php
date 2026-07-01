<?php

namespace App\Twig;

use App\Repository\EventConfigRepository;
use App\Repository\PageContentRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Application-wide Twig helpers for admin and public templates.
 */
class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private RequestStack $requestStack;
    private EventConfigRepository $eventConfigRepository;
    private PageContentRepository $pageContentRepository;

    public function __construct(
        RequestStack $requestStack,
        EventConfigRepository $eventConfigRepository,
        PageContentRepository $pageContentRepository
    ) {
        $this->requestStack = $requestStack;
        $this->eventConfigRepository = $eventConfigRepository;
        $this->pageContentRepository = $pageContentRepository;
    }

    public function getGlobals(): array
    {
        $configs = $this->eventConfigRepository->findAll();
        return [
            'event_config' => !empty($configs) ? $configs[0] : null,
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nav_item_class', [$this, 'navItemClass'], ['is_safe' => ['html']]),
            new TwigFunction('get_public_pages', [$this, 'getPublicPages']),
        ];
    }

    public function getPublicPages(): array
    {
        return $this->pageContentRepository->findBy([], ['title' => 'ASC']);
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('role_label', [$this, 'roleLabel']),
        ];
    }

    public function navItemClass(string $routePrefix): string
    {
        $currentRouteName = $this->requestStack->getCurrentRequest()?->attributes->get('_route') ?? '';
        if (strpos($currentRouteName, $routePrefix) !== false) {
            return 'class="nav-link nav-link--active" aria-current="page"';
        }
        return 'class="nav-link" ';
    }

    /**
     * Converts a Symfony role string to a human-readable label.
     *
     * Usage: {{ 'ROLE_ADMIN'|role_label }}  → 'Administrador'
     */
    public function roleLabel(string $role): string
    {
        return match ($role) {
            'ROLE_ADMIN' => 'Administrador',
            'ROLE_USER'  => 'Usuário',
            default      => ucfirst(strtolower(str_replace(['ROLE_', '_'], ['', ' '], $role))),
        };
    }
}
