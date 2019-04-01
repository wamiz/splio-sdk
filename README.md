
# Splio PHP SDK

PHP wrapper for Splio CRM and router.

## Installation

    composer config repositories.splio-sdk vcs https://forge.wamiz.com/common/splio-sdk.git
    composer require common/splio-sdk:master

## Usage

    $config = array(
        'domain'    =>  's3s.fr',
        'universe'  =>  SPLIO_UNVERSE_NAME,
        'data'      =>  array(
            'key'       => YOUR_API_DATA_KEY,
            'version'   => API_VERSION // 1.9
        ),
        'trigger'   =>  array(
            'key'       => YOUR_API_TRIGGER_KEY,
            'version'   => API_VERSION // 1.9
        ),
        'launch'    =>  array(
            'key'       => YOUR_API_LAUNCH_KEY,
            'version'   => API_VERSION // 1.9
        )
    );

    $sdk = new SplioSdk($config);

## Data API

### Access to data API :

    $dataApi = $sdk->getService()->getData();

### Available methods :

 - getLists
 - getContact
 - createContact
 - updateContact
 - deleteContact
 - isContactBlacklisted
 - addContactToBlacklist

#### getLists()
Retrieve all lists from the specified universe. Returns EmailListCollection object.

----

#### getContact($email)
Retrieve all infos about the user, including custom fields and subscribed lists.

----

#### createContact(Contact $contact)
Create a contact, see example below

----

#### updateContact(Contact $contact)
Update a contact, you can view contact options on example below.

----

#### deleteContact($email)
Delete a contact from email address

----

### Examples :

#### Add user into contacts

    $contact = new Splio\Service\Data\Contact\Contact();
    
    $contact->setEmail('john@doe.com'); // required
    $contact->setFirstname('John'); // optional
    $contact->setLastname('Doe'); // optional
    
    $user = $dataApi->createContact($contact);

##### Adding lists to contact

    $lists = $dataSdk->getLists();
    $list1 = $lists->retrieveById(0);
    $contact->addEmailList($list1);
    
    $list2 = $lists->retrieveById(1);
    $contact->addEmailList($list2);
    
##### Setting custom fields

    $customFields = $dataSdk->getFields();
    $field1 = $customFields->retrieveById(0);
    $contact->addCustomField($field1);
    
    $field2 = $customFields->retrieveById(1);
    $contact->addCustomField($field2);
    
Here is the output :

```json
{
    "email": "john@doe.com",
    "date": "2019-03-25 12:21:04",
    "firstname": "John",
    "lastname": "Doe",
    "lang": "fr",
    "cellphone": "",
    "id": "1",
    "fields": [
        {
            "id": "0",
            "name": "Best character",
            "value": "Jaina"
        }
    ],
    "lists": [
        {
            "id": "0",
            "name": "Foo"
        },
        {
            "id": "1",
            "name": "Bar"
        }
    ]
}
```