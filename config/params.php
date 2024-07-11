<?php

use yiidreamteam\smspilot\Api;

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'smsPilotApiKey' => !empty(getenv('SMS_PILOT_API_KEY')) ?
        getenv('SMS_PILOT_API_KEY') :
        Api::SANDBOX_KEY,
    'smsPilotSandbox' => getenv('SMS_PILOT_SANDBOX') ?? true,
];
