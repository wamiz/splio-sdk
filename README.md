
# Splio PHP SDK

PHP wrapper for Splio CRM and router.

## Installation

    composer config repositories.splio-sdk vcs https://forge.wamiz.com/common/splio-sdk.git
    composer require common/splio-sdk:master

## Usage

### Configuration

    $config = array(
        'domain'    =>  's3s.fr',
        'universe'  =>  SPLIO_UNVERSE_NAME,
        'data'      =>  array(
            'key'           => YOUR_API_DATA_KEY,
            'version'       => API_VERSION // 1.9
            'sftp_host'     => REMOTE_SPLIO_FTP_HOST
            'sftp_port'     => REMOTE_SPLIO_FTP_PORT
            'sftp_username' => REMOTE_SPLIO_FTP_USERNAME
            'sftp_password' => REMOTE_SPLIO_FTP_PASSWORD
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

### API

    - [Data API](docs/data/README.md)
    - [Trigger API](docs/trigger/README.md)
    - [Launch API](docs/launch/README.md)