@include('components.company.company-document-card', [
    'icon' => $icon ?? 'fa-regular fa-folder-open',
    'title' => $title ?? 'Product Catalogue.pdf',
    'meta' => $meta ?? '24 pages',
    'showUrl' => $showUrl ?? '#',
    'editUrl' => $editUrl ?? '#',
])
