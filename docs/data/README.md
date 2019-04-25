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

#### createContact(Splio\Service\Data\Contact\Contact $contact)
Create a contact, see example below

----

#### updateContact(Splio\Service\Data\Contact\Contact $contact)
Update a contact, you can view contact options on example below.

----

#### deleteContact(string $email)
Delete a contact from email address

----

### Examples :

#### Add user into contacts

    $contact = new Splio\Service\Data\Contact\Contact();
    
    $contact->setEmail('john@doe.com'); // required
    $contact->setFirstname('John'); // optional
    $contact->setLastname('Doe'); // optional
    
    $user = $dataApi->createContact($contact);

#### Adding lists to contact

    $lists = $dataSdk->getLists();
    $list1 = $lists->retrieveById(0);
    $contact->addEmailList($list1);
    
    $list2 = $lists->retrieveById(1);
    $contact->addEmailList($list2);
    
#### Setting custom fields

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