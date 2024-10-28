<?php

namespace Biologed\Revive;

use Error;
use DateTime;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use PhpXmlRpc\Client;
use PhpXmlRpc\Encoder;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;
use Biologed\Revive\Entities\Entity;
use Biologed\Revive\Entities\Advertiser;
use Biologed\Revive\Entities\Agency;
use Biologed\Revive\Entities\Banner;
use Biologed\Revive\Entities\Campaign;
use Biologed\Revive\Entities\Channel;
use Biologed\Revive\Entities\Publisher;
use Biologed\Revive\Entities\Targeting;
use Biologed\Revive\Entities\User;
use Biologed\Revive\Entities\Variable;
use Biologed\Revive\Entities\Zone;
use Illuminate\Support\Facades\Config;

class Api
{
    private static mixed $result;
    private static ?Method $method;
    private static bool $timezone = true;
    private static ?CarbonImmutable $startDate;
    private static ?CarbonImmutable $endDate;
    private static ?int $advertiserId;
    private static ?int $agencyId;
    private static ?int $campaignId;
    private static ?int $bannerId;
    private static ?int $publisherId;
    private static ?int $userId;
    private static ?int $accountId;
    private static ?int $zoneId;
    private static ?int $channelId;
    private static ?int $variableId;
    private static ?int $websiteId;
    private static ?Advertiser $advertiserEntity;
    private static ?Agency $agencyEntity;
    private static ?Campaign $campaignEntity;
    private static ?Banner $bannerEntity;
    private static ?Publisher $publisherEntity;
    private static ?User $userEntity;
    private static ?Zone $zoneEntity;
    private static ?Channel $channelEntity;
    private static ?Variable $variableEntity;
    private static ?string $sessionId;
    private static ?Api $_instance = null;
    private function __construct () {}
    public static function init(): self
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        self::$_instance->setMethod(Method::logon);
        self::$sessionId = self::$_instance->send([Config::get('revive.username'), Config::get('revive.password')]);
        self::$_instance->clearMethod();
        return self::$_instance;
    }
    public function filter($callback): self
    {
        self::$result = array_filter(self::$result, $callback);
        return $this;
    }
    public function get(): mixed
    {
        return self::$result;
    }
    public function getCurrentMethod(): string
    {
        return self::$method->value;
    }
    public function getCurrentSession(): string
    {
        return self::$sessionId;
    }
    public function clearMethod(): self
    {
        self::$method = null;
        return $this;
    }
    public function setMethod(Method $method): self
    {
        if (Method::isValid($method)) {
            self::$method = $method;
        } else {
            throw new Error('Method not allowed');
        }
        return $this;
    }
    public function setAdvertiserId(int $advertiserId): self
    {
        self::$advertiserId = $advertiserId;
        return $this;
    }
    public function setAgencyId(int $agencyId): self
    {
        self::$agencyId = $agencyId;
        return $this;
    }
    public function setCampaignId(int $campaignId): self
    {
        self::$campaignId = $campaignId;
        return $this;
    }
    public function setBannerId(int $bannerId): self
    {
        self::$bannerId = $bannerId;
        return $this;
    }
    public function setPublisherId(int $publisherId): self
    {
        self::$publisherId = $publisherId;
        return $this;
    }
    public function setUserId(int $userId): self
    {
        self::$userId = $userId;
        return $this;
    }
    public function setAccountId(int $accountId): self
    {
        self::$accountId = $accountId;
        return $this;
    }
    public function setZoneId(int $zoneId): self
    {
        self::$zoneId = $zoneId;
        return $this;
    }
    public function setChannelId(int $channelId): self
    {
        self::$channelId = $channelId;
        return $this;
    }
    public function setVariableId(int $variableId): self
    {
        self::$variableId = $variableId;
        return $this;
    }
    public function setWebsiteId(int $websiteId): self
    {
        self::$websiteId = $websiteId;
        return $this;
    }
    public function setAdvertiserEntity(Advertiser $advertiserEntity): self
    {
        self::$advertiserEntity = $advertiserEntity;
        return $this;
    }
    public function setAgencyEntity(Agency $agencyEntity): self
    {
        self::$agencyEntity = $agencyEntity;
        return $this;
    }
    public function setCampaignEntity(Campaign $campaignEntity): self
    {
        self::$campaignEntity = $campaignEntity;
        return $this;
    }
    public function setBannerEntity(Banner $bannerEntity): self
    {
        self::$bannerEntity = $bannerEntity;
        return $this;
    }
    public function setPublisherEntity(Publisher $publisherEntity): self
    {
        self::$publisherEntity = $publisherEntity;
        return $this;
    }
    public function setUserEntity(User $userEntity): self
    {
        self::$userEntity = $userEntity;
        return $this;
    }
    public function setZoneEntity(Zone $zoneEntity): self
    {
        self::$zoneEntity = $zoneEntity;
        return $this;
    }
    public function setChannelEntity(Channel $channelEntity): self
    {
        self::$channelEntity = $channelEntity;
        return $this;
    }
    public function setVariableEntity(Variable $variableEntity): self
    {
        self::$variableEntity = $variableEntity;
        return $this;
    }
    public function setStartDate(Carbon|DateTime|string $date): self
    {
        self::$startDate = Utils::compareDate($date);
        return $this;
    }
    public function setEndDate(Carbon|DateTime|string $date): self
    {
        self::$endDate = Utils::compareDate($date);
        return $this;
    }
    public function setTimezone(bool $timezone = true): self
    {
        self::$timezone = $timezone;
        return $this;
    }
    public function logoff(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::logoff);
        }
        if (self::$method !== Method::logoff) {
            throw new Error('Incorrect API method');
        }
        $this->send();
        return $this;
    }
    public function getAgencyList(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getAgencyList);
        }
        if (self::$method !==Method::getAgencyList) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send();
        self::$result = [];
        foreach ($dataList as $data) {
            self::$agencyEntity = new Agency();
            self::$agencyEntity->readDataFromArray($data);
            self::$result[] = self::$agencyEntity;
        }
        return $this;
    }
    public function addAdvertiser(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addAdvertiser);
        }
        if (self::$method !== Method::addAdvertiser) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$advertiserEntity]);
        return $this;
    }
    public function modifyAdvertiser(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyAdvertiser);
        }
        if (self::$method !== Method::modifyAdvertiser) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$advertiserEntity]);
        return $this;
    }
    public function deleteAdvertiser(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::deleteAdvertiser);
        }
        if (self::$method !== Method::deleteAdvertiser) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$advertiserId]);
        return $this;
    }
    public function getAdvertiser(): Advertiser
    {
        if (self::$method === null) {
            $this->setMethod(Method::getAdvertiser);
        }
        if (self::$method !== Method::getAdvertiser) {
            throw new Error('Incorrect API method');
        }
        self::$advertiserEntity = new Advertiser();
        self::$result = $this->send([self::$sessionId, self::$advertiserId]);
        self::$advertiserEntity->readDataFromArray(self::$result);
        return self::$advertiserEntity;
    }
    public function advertiserDailyStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::advertiserDailyStatistics);
        }
        if (self::$method !== Method::advertiserDailyStatistics) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$advertiserId, self::$startDate, self::$endDate, self::$timezone]);
        foreach ($dataList as $key => $data) {
            $dataList[$key]['day'] = CarbonImmutable::parse($data['day'])->format('Y-m-d');
        }
        self::$result = $dataList;
        return $this;
    }
    public function advertiserCampaignStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::advertiserCampaignStatistics);
        }
        if (self::$method !== Method::advertiserCampaignStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$advertiserId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function advertiserBannerStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::advertiserBannerStatistics);
        }
        if (self::$method !== Method::advertiserBannerStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$advertiserId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function advertiserPublisherStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::advertiserPublisherStatistics);
        }
        if (self::$method !== Method::advertiserPublisherStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$advertiserId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function advertiserZoneStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::advertiserZoneStatistics);
        }
        if (self::$method !== Method::advertiserZoneStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$advertiserId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function getCampaignListByAdvertiserId(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getCampaignListByAdvertiserId);
        }
        if (self::$method !== Method::getCampaignListByAdvertiserId) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$advertiserId]);
        foreach ($dataList as $data) {
            self::$campaignEntity = new Campaign();
            self::$campaignEntity->readDataFromArray($data);
            self::$result[] = self::$campaignEntity;
        }
        return $this;
    }
    public function addAgency(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addAgency);
        }
        if (self::$method !== Method::addAgency) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$agencyEntity]);
        return $this;
    }
    public function modifyAgency(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyAgency);
        }
        if (self::$method !== Method::modifyAgency) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$agencyEntity]);
        return $this;
    }
    public function deleteAgency(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::deleteAgency);
        }
        if (self::$method !== Method::deleteAgency) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$agencyId]);
        return $this;
    }
    public function getAgency(): Agency
    {
        if (self::$method === null) {
            $this->setMethod(Method::getAgency);
        }
        if (self::$method !== Method::getAgency) {
            throw new Error('Incorrect API method');
        }
        $data = $this->send([self::$sessionId, self::$agencyId]);
        self::$agencyEntity = new Agency();
        self::$agencyEntity->readDataFromArray($data);
        return self::$agencyEntity;
    }
    public function agencyDailyStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::agencyDailyStatistics);
        }
        if (self::$method !== Method::agencyDailyStatistics) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$agencyId, self::$startDate, self::$endDate, self::$timezone]);
        foreach ($dataList as $key => $data) {
            $dataList[$key]['day'] = CarbonImmutable::parse($data['day'])->format('Y-m-d');
        }
        self::$result = $dataList;
        return $this;
    }
    public function agencyAdvertiserStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::agencyAdvertiserStatistics);
        }
        if (self::$method !== Method::agencyAdvertiserStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$agencyId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function agencyCampaignStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::agencyCampaignStatistics);
        }
        if (self::$method !== Method::agencyCampaignStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$agencyId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function agencyBannerStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::agencyBannerStatistics);
        }
        if (self::$method !== Method::agencyBannerStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$agencyId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function agencyPublisherStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::agencyPublisherStatistics);
        }
        if (self::$method !== Method::agencyPublisherStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$agencyId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function agencyZoneStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::agencyZoneStatistics);
        }
        if (self::$method !== Method::agencyZoneStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$agencyId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function getAdvertiserListByAgencyId(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getAdvertiserListByAgencyId);
        }
        if (self::$method !== Method::getAdvertiserListByAgencyId) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$agencyId]);
        self::$result = [];
        foreach ($dataList as $data) {
            $advertiserEntity = new Advertiser();
            $advertiserEntity->readDataFromArray($data);
            self::$result[] = $advertiserEntity;
        }
        return $this;
    }
    public function getPublisherListByAgencyId(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getPublisherListByAgencyId);
        }
        if (self::$method !== Method::getPublisherListByAgencyId) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$agencyId]);
        self::$result = [];
        foreach ($dataList as $data) {
            $publisherEntity = new Publisher();
            $publisherEntity->readDataFromArray($data);
            self::$result[] = $publisherEntity;
        }
        return $this;
    }
    public function getChannelListByAgencyId(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getChannelListByAgencyId);
        }
        if (self::$method !== Method::getChannelListByAgencyId) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$agencyId]);
        self::$result = [];
        foreach ($dataList as $data) {
            $channelEntity = new Channel();
            $channelEntity->readDataFromArray($data);
            self::$result[] = $channelEntity;
        }
        return $this;
    }
    public function addCampaign(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addCampaign);
        }
        if (self::$method !== Method::addCampaign) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$campaignEntity]);
        return $this;
    }
    public function modifyCampaign(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyCampaign);
        }
        if (self::$method !== Method::modifyCampaign) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$campaignEntity]);
        return $this;
    }
    public function deleteCampaign(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::deleteCampaign);
        }
        if (self::$method !== Method::deleteCampaign) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$campaignId]);
        return $this;
    }
    public function getCampaign(): Campaign
    {
        if (self::$method === null) {
            $this->setMethod(Method::getCampaign);
        }
        if (self::$method !== Method::getCampaign) {
            throw new Error('Incorrect API method');
        }
        $data = $this->send([self::$sessionId, self::$campaignId]);
        self::$campaignEntity = new Campaign();
        self::$campaignEntity->readDataFromArray($data);
        return self::$campaignEntity;
    }
    public function campaignDailyStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::campaignDailyStatistics);
        }
        if (self::$method !== Method::campaignDailyStatistics) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$campaignId, self::$startDate, self::$endDate, self::$timezone]);
        foreach ($dataList as $key => $data) {
            $dataList[$key]['day'] = CarbonImmutable::parse($data['day'])->format('Y-m-d');
        }
        self::$result = $dataList;
        return $this;
    }
    public function campaignBannerStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::campaignBannerStatistics);
        }
        if (self::$method !== Method::campaignBannerStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$campaignId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function campaignPublisherStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::campaignPublisherStatistics);
        }
        if (self::$method !== Method::campaignPublisherStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$campaignId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function campaignZoneStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::campaignZoneStatistics);
        }
        if (self::$method !== Method::campaignZoneStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$campaignId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function getBannerListByCampaignId(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getBannerListByCampaignId);
        }
        if (self::$method !== Method::getBannerListByCampaignId) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$campaignId]);
        self::$result = [];
        foreach ($dataList as $data) {
            self::$bannerEntity = new Banner();
            self::$bannerEntity->readDataFromArray($data);
            self::$result[] = self::$bannerEntity;
        }
        return $this;
    }
    public function linkCampaign(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::linkCampaign);
        }
        if (self::$method !== Method::linkCampaign) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId, self::$campaignId]);
        return $this;
    }
    public function unlinkCampaign(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::unlinkCampaign);
        }
        if (self::$method !== Method::unlinkCampaign) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId, self::$campaignId]);
        return $this;
    }
    public function addBanner(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addBanner);
        }
        if (self::$method !== Method::addBanner) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$bannerEntity]);
        return $this;
    }
    public function modifyBanner(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyBanner);
        }
        if (self::$method !== Method::modifyBanner) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$bannerEntity]);
        return $this;
    }
    public function deleteBanner(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::deleteBanner);
        }
        if (self::$method !== Method::deleteBanner) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$bannerId]);
        return $this;
    }
    public function getBanner(): Banner
    {
        if (self::$method === null) {
            $this->setMethod(Method::getBanner);
        }
        if (self::$method !== Method::getBanner) {
            throw new Error('Incorrect API method');
        }
        $data = $this->send([self::$sessionId, self::$bannerId]);
        self::$bannerEntity = new Banner();
        self::$bannerEntity->readDataFromArray($data);
        return self::$bannerEntity;
    }
    public function getBannerTargeting(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getBannerTargeting);
        }
        if (self::$method !== Method::getBannerTargeting) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$bannerId]);
        self::$result = [];
        foreach ($dataList as $data) {
            $targetingEntity = new Targeting();
            $targetingEntity->readDataFromArray($data);
            self::$result[] = $targetingEntity;
        }
        return $this;
    }
    public function setBannerTargeting(array $dataList): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::setBannerTargeting);
        }
        if (self::$method !== Method::setBannerTargeting) {
            throw new Error('Incorrect API method');
        }
        $result = [];
        foreach ($dataList as $data) {
            $targetingEntity = new Targeting();
            $targetingEntity->readDataFromArray($data);
            $result[] = $targetingEntity;
        }
        self::$result = $this->send([self::$sessionId, self::$bannerId, $result]);
        return $this;
    }
    public function bannerDailyStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::bannerDailyStatistics);
        }
        if (self::$method !== Method::bannerDailyStatistics) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$bannerId, self::$startDate, self::$endDate, self::$timezone]);
        foreach ($dataList as $key => $data) {
            $dataList[$key]['day'] = CarbonImmutable::parse($data['day'])->format('Y-m-d');
        }
        self::$result = $dataList;
        return $this;
    }
    public function bannerPublisherStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::bannerPublisherStatistics);
        }
        if (self::$method !== Method::bannerPublisherStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$bannerId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function bannerZoneStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::bannerZoneStatistics);
        }
        if (self::$method !== Method::bannerZoneStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$bannerId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function linkBanner(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::linkBanner);
        }
        if (self::$method !== Method::linkBanner) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId, self::$bannerId]);
        return $this;
    }
    public function unlinkBanner(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::unlinkBanner);
        }
        if (self::$method !== Method::unlinkBanner) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId, self::$bannerId]);
        return $this;
    }
    public function addPublisher(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addPublisher);
        }
        if (self::$method !== Method::addPublisher) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$publisherEntity]);
        return $this;
    }
    public function modifyPublisher(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyPublisher);
        }
        if (self::$method !== Method::modifyPublisher) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$publisherEntity]);
        return $this;
    }
    public function getPublisher(): Publisher
    {
        if (self::$method === null) {
            $this->setMethod(Method::getPublisher);
        }
        if (self::$method !== Method::getPublisher) {
            throw new Error('Incorrect API method');
        }
        $dataPublisher = $this->send([self::$sessionId, self::$publisherId]);
        self::$publisherEntity = new Publisher();
        self::$publisherEntity->readDataFromArray($dataPublisher);
        return self::$publisherEntity;
    }
    public function deletePublisher(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::deletePublisher);
        }
        if (self::$method !== Method::deletePublisher) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$publisherId]);
        return $this;
    }
    public function publisherDailyStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::publisherDailyStatistics);
        }
        if (self::$method !== Method::publisherDailyStatistics) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$publisherId, self::$startDate, self::$endDate, self::$timezone]);
        foreach ($dataList as $key => $data) {
            $dataList[$key]['day'] = CarbonImmutable::parse($data['day'])->format('Y-m-d');
        }
        self::$result = $dataList;
        return $this;
    }
    public function publisherZoneStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::publisherZoneStatistics);
        }
        if (self::$method !== Method::publisherZoneStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$publisherId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function publisherAdvertiserStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::publisherAdvertiserStatistics);
        }
        if (self::$method !== Method::publisherAdvertiserStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$publisherId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function publisherCampaignStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::publisherCampaignStatistics);
        }
        if (self::$method !== Method::publisherCampaignStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$publisherId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function publisherBannerStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::publisherBannerStatistics);
        }
        if (self::$method !== Method::publisherBannerStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$publisherId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function getZoneListByPublisherId(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getZoneListByPublisherId);
        }
        if (self::$method !== Method::getZoneListByPublisherId) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$publisherId]);
        self::$result = [];
        foreach ($dataList as $data) {
            $zoneEntity = new Zone();
            $zoneEntity->readDataFromArray($data);
            self::$result[] = $zoneEntity;
        }
        return $this;
    }
    public function addUser(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addUser);
        }
        if (self::$method !== Method::addUser) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$userEntity]);
        return $this;
    }
    public function modifyUser(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyUser);
        }
        if (self::$method !== Method::modifyUser) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$userEntity]);
        return $this;
    }
    public function deleteUser(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::deleteUser);
        }
        if (self::$method !== Method::deleteUser) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$userId]);
        return $this;
    }
    public function getUser(): User
    {
        if (self::$method === null) {
            $this->setMethod(Method::getUser);
        }
        if (self::$method !== Method::getUser) {
            throw new Error('Incorrect API method');
        }
        $data = $this->send([self::$sessionId, self::$userId]);
        self::$userEntity = new User();
        self::$userEntity->readDataFromArray($data);
        return self::$userEntity;
    }
    public function linkUserToAdvertiserAccount(array $permissions = []): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::linkUserToAdvertiserAccount);
        }
        if (self::$method !== Method::linkUserToAdvertiserAccount) {
            throw new Error('Incorrect API method');
        }
        $data = [self::$userId, self::$accountId];
        if ($permissions) {
            $data[] = $permissions;
        }
        self::$result = $this->send([self::$sessionId, $data]);
        return $this;
    }
    public function getUserListByAccountId(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getUserListByAccountId);
        }
        if (self::$method !== Method::getUserListByAccountId) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$accountId]);
        self::$result = [];
        foreach ($dataList as $data) {
            $userEntity = new User();
            $userEntity->readDataFromArray($data);
            self::$result[] = $userEntity;
        }
        return $this;
    }
    public function updateSsoUserId(int $oldSsoUserId, int $newSsoUserId): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::updateSsoUserId);
        }
        if (self::$method !== Method::updateSsoUserId) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, $oldSsoUserId, $newSsoUserId]);
        return $this;
    }
    public function updateUserEmailBySsoId(int $ssoUserId, string $email): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::updateUserEmailBySsoId);
        }
        if (self::$method !== Method::updateUserEmailBySsoId) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, $ssoUserId, $email]);
        return $this;
    }
    public function addZone(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addZone);
        }
        if (self::$method !== Method::addZone) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneEntity]);
        return $this;
    }
    public function modifyZone(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyZone);
        }
        if (self::$method !== Method::modifyZone) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneEntity]);
        return $this;
    }
    public function deleteZone(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::deleteZone);
        }
        if (self::$method !== Method::deleteZone) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId]);
        return $this;
    }
    public function getZone(): Zone
    {
        if (self::$method === null) {
            $this->setMethod(Method::getZone);
        }
        if (self::$method !== Method::getZone) {
            throw new Error('Incorrect API method');
        }
        $data = $this->send([self::$sessionId, self::$zoneId]);
        $zoneEntity = new Zone();
        $zoneEntity->readDataFromArray($data);
        return $zoneEntity;
    }
    public function zoneDailyStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::zoneDailyStatistics);
        }
        if (self::$method !== Method::zoneDailyStatistics) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$zoneId, self::$startDate, self::$endDate, self::$timezone]);
        foreach ($dataList as $key => $data) {
            $dataList[$key]['day'] = CarbonImmutable::parse($data['day'])->format('Y-m-d');
        }
        self::$result = $dataList;
        return $this;
    }
    public function zoneAdvertiserStatistics(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::zoneAdvertiserStatistics);
        }
        if (self::$method !== Method::zoneAdvertiserStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function zoneCampaignStatistics(int $zoneId): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::zoneCampaignStatistics);
        }
        if (self::$method !== Method::zoneCampaignStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function zoneBannerStatistics(int $zoneId): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::zoneBannerStatistics);
        }
        if (self::$method !== Method::zoneBannerStatistics) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId, self::$startDate, self::$endDate, self::$timezone]);
        return $this;
    }
    public function generateTags(string $codeType, array $params = null): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::generateTags);
        }
        if (self::$method !== Method::generateTags) {
            throw new Error('Incorrect API method');
        }
        if (!isset($params)) {
            $params = [];
        }
        self::$result = $this->send([self::$sessionId, self::$zoneId, $codeType, $params]);
        return $this;
    }
    public function addChannel(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addChannel);
        }
        if (self::$method !== Method::generateTags) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$channelEntity]);
        return $this;
    }
    public function modifyChannel(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyChannel);
        }
        if (self::$method !== Method::generateTags) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$channelEntity]);
        return $this;
    }
    public function deleteChannel(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::deleteChannel);
        }
        if (self::$method !== Method::generateTags) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$channelId]);
        return $this;
    }
    public function getChannel(int $channelId): Channel
    {
        if (self::$method === null) {
            $this->setMethod(Method::getChannel);
        }
        if (self::$method !== Method::generateTags) {
            throw new Error('Incorrect API method');
        }
        $data = $this->send([self::$sessionId, self::$channelId]);
        self::$channelEntity = new Channel();
        self::$channelEntity->readDataFromArray($data);
        return self::$channelEntity;
    }
    public function getChannelTargeting(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getChannelTargeting);
        }
        if (self::$method !== Method::generateTags) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$channelId]);
        self::$result = [];
        foreach ($dataList as $data) {
            $targetingEntity = new Targeting();
            $targetingEntity->readDataFromArray($data);
            self::$result[] = $targetingEntity;
        }
        return $this;
    }
    public function getChannelListByWebsiteId(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::getChannelListByWebsiteId);
        }
        if (self::$method !== Method::generateTags) {
            throw new Error('Incorrect API method');
        }
        $dataList = $this->send([self::$sessionId, self::$websiteId]);
        self::$result = [];
        foreach ($dataList as $data) {
            $channelEntity = new Channel();
            $channelEntity->readDataFromArray($data);
            self::$result[] = $channelEntity;
        }
        return $this;
    }
    public function updateSsoChannelId(int $oldSsoChannelId, int $newSsoChannelId): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::updateSsoChannelId);
        }
        if (self::$method !== Method::updateSsoChannelId) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, $oldSsoChannelId, $newSsoChannelId]);
        return $this;
    }
    public function setChannelTargeting(array $dataList): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::setChannelTargeting);
        }
        if (self::$method !== Method::setChannelTargeting) {
            throw new Error('Incorrect API method');
        }
        $result = [];
        foreach ($dataList as $data) {
            $targetingEntity = new Targeting();
            $targetingEntity->readDataFromArray($data);
            $result[] = $targetingEntity;
        }
        self::$result = $this->send([self::$sessionId, self::$channelId, $result]);
        return $this;
    }
    public function addVariable(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::addVariable);
        }
        if (self::$method !== Method::addVariable) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$variableEntity]);
        return $this;
    }
    public function modifyVariable(): self
    {
        if (self::$method === null) {
            $this->setMethod(Method::modifyVariable);
        }
        if (self::$method !== Method::modifyVariable) {
            throw new Error('Incorrect API method');
        }
        self::$result = $this->send([self::$sessionId, self::$variableEntity]);
        return $this;
    }
    public function getVariable(): Variable
    {
        if (self::$method === null) {
            $this->setMethod(Method::getVariable);
        }
        if (self::$method !== Method::getVariable) {
            throw new Error('Incorrect API method');
        }
        $data = $this->send([self::$sessionId, self::$variableId]);
        self::$variableEntity = new Variable();
        self::$variableEntity->readDataFromArray($data);
        return self::$variableEntity;
    }
    private function send(array $data = null): mixed
    {
        $message = [];
        $encoder = new Encoder();
        if ($data !== null) {
            foreach ($data as $element) {
                if ($element instanceof Entity) {
                    $message[] = Utils::getEntityWithNotNullFields($element);
                }
                if ($element instanceof DateTime) {
                    $value = $element->format('Ymd\TH:i:s');
                    $message[] = new Value($value, 'dateTime.iso8601');
                } else {
                    $message[] = $encoder->encode($element);
                }
            }
        }
        $client = new Client(rtrim(Config::get('revive.basepath'), '/') . '/', Config::get('revive.host'), Config::get('revive.port'), Config::get('revive.ssl') ? 'https' : 'http');
        $request = new Request(self::$method->value, $message);
        $response = $client->send($request, Config::get('revive.timeout'));
        if ($response && $response->faultCode() === 0) {
            return $encoder->decode($response->value());
        }
        trigger_error('XML-RPC Error (' . $response->faultCode() . '): ' . $response->faultString() . ' in method ' . self::$method->value . '()', E_USER_ERROR);
    }
}
