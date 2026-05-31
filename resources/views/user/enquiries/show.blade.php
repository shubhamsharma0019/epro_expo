@include('user.partials.detail-page', [
    'title' => 'Enquiry Details',
    'eyebrow' => 'Visitor enquiry',
    'heading' => 'Product pricing enquiry',
    'description' => 'Your enquiry was sent to OmniTech Solutions. Track reply status and continue the conversation from your dashboard.',
    'backUrl' => '/user/enquiries',
    'meta' => [['Status', 'Open'], ['Company', 'OmniTech'], ['Sent', 'Today']],
])
