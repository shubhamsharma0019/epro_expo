@include('user.partials.list-page', [
    'title' => 'My Enquiries',
    'variant' => 'inbox',
    'eyebrow' => 'Message Center',
    'description' => 'Track messages, product questions, meeting requests, and exhibitor replies.',
    'icon' => 'fa-regular fa-message',
    'items' => [
        ['Product pricing enquiry', 'Sent to OmniTech Solutions', 'Open', '/user/enquiries/1'],
        ['Demo meeting request', 'Sent to CloudBridge', 'Replied', '/user/enquiries/2'],
        ['Catalogue request', 'Sent to Healthcore Labs', 'Pending', '/user/enquiries/3'],
    ],
])
