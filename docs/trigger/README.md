## Trigger API

### Access to trigger API :

    $triggerApi = $sdk->getService()->getTrigger();

### Available methods :

 - send

 #### send($messageId, Splio\Service\Trigger\Recipient\RecipientCollection $recipients)
 Send email template to defined recipients

| Param | Description |
| --: | -- |
| $messageId | Splio id of the email template (provided by splio) |
| $recipients | Collection of recipient (see structure below) |

 ##### Recipient structure :

|  Method | Description |
| --: | -- |
| **setEmail**(string *$email*) | Set recipient email |
| **setFirstname** (string *$firstname*) | Set recipient firstname |
| **setLastname**(string *$lastname*) | Set recipient lastname |
| **setCellphone**(string *$cellphone*) | Set recipient cellphone |
| **addCustomField**(integer $customFieldId, string $customFieldValue) | Set custom field to pass to template |