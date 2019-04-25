## Launch API

### Access to launch API :

    $launchApi = $sdk->getService()->getLaunch();

### Available methods :

 - launchCampaign

 #### launchCampaign(Splio\Service\Launch\Message $message)
 Launch campaign with message instance (see methods below).

 ##### Message structure :

|  Method | Description |
| --: | -- |
| **setSenderEmail**(string *$email*) | Set sender email |
| **setSenderName** (string *$name*) | Set sender name |
| **setReplyTo**(string *$email*) | Email address used to reply to campaign |
| **addList**(SplioSdk\Service\Data\EmailList\EmailList *$list*) | Add list to send to |
| **addFilter**(int *$filterId*) | Adding filter to send to |
| **setUrl**(string *$url*) | Set public and unprotected URL with email HTML content |
| **setStartTime**(string *$startTime*) | Set date to schedule *(format : YYYY-mm-dd HH:ii:ss)*