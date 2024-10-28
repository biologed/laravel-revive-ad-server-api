
# Revive Ad Server XML RPC API
## Uses
- [phpxmlrpc/phpxmlrpc](https://github.com/gggeek/phpxmlrpc)
- [illuminate/support](https://github.com/illuminate/support)
##### Laravel config/env
```bash
php artisan vendor:publish --provider="Biologed\Revive\ReviveServiceProvider"
```
If you want to edit the config, use the ENV constants in the .env file
```dotenv
REVIVE_HOST=example.com
REVIVE_BASEPATH=/www/api/v2/xmlrpc/
REVIVE_USERNAME=admin
REVIVE_PASSWORD=password
REVIVE_PORT=0
REVIVE_SSL=1
REVIVE_TIMEOUT=15
```
## Examples
```php
use Biologed\Revive\Api as ReviveApi;
use Biologed\Revive\Entities\Agency as ReviveAgencyEntity;

$agencyEntity = ReviveApi::init()->setAgencyId(1)->getAgency();

//create new Agency
$reviveAgencyEntity = new ReviveAgencyEntity();
$createAgencyEntity = $reviveAgencyEntity->readDataFromArray([
    'agencyId' => 0,
    'accountId' => 1,
    'agencyName' => 'Agency',
    'contactName' => 'Contact',
    'password' => 'password',
    'emailAddress' => 'email@mail.com',
]);
//add new Agency to Revive Ad Server
ReviveApi::init()
    ->setAdvertiserEntity($entity)
    ->addAgency();

//get list of Agencies
$agencyList = ReviveApi::init()
    ->getAgencyList();

$advertiserCampaignStatistics = ReviveApi::init()
    ->setAdvertiserId(5)
    ->setStartDate(CarbonImmutable::yesterday())
    ->setEndDate(CarbonImmutable::today())
    ->advertiserCampaignStatistics()
    ->get();
```
