
# Splio PHP SDK

PHP wrapper for Splio CRM and router.

## Installation

    composer config repositories.repo-name vcs https://forge.wamiz.com/common/splio-sdk.git
    composer require common/splio-sdk:dev-branch-name

## Usage

    $config = array(
        'data'   =>  array(
            'key'       => YOUR_API_KEY
        ),
        'trigger'   =>  array(
            'key'       => YOUR_API_KEY
        ),
        'launch'   =>  array(
            'key'       => YOUR_API_KEY
        )
    );

    $sdk = new SplioSdk($config);
