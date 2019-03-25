
# Splio PHP SDK

PHP wrapper for Splio CRM and router.

## Installation

    composer config repositories.repo-name vcs https://forge.wamiz.com/common/splio-sdk.git
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

**Access to data API :**

    $dataApi = $sdk->getService()->getData();

**Available methods :**

 - getList
 - getContact
 - createContact
 - updateContact
 - deleteContact
 - isContactBlacklisted
 - addContactToBlacklist

__**Examples : **__

***Add user into contacts***

    $contact = [
	    'email' => 'john@doe.com', // required
	    'firstname' => 'John', // optional
	    'lastname' => 'Doe', // optional
	    'lists' => [
		    'id' => 0,
		    'id' => 1
		    ]
		 ], // Adding user into our 2 first lists
	    'fields' => [
		    'id' => 0,
		    'name' => 'Best character',
		    'value' => 'Jaina'
		 ] // Setting custom fields
    ];
    $user = $dataApi->createContact($contact);

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