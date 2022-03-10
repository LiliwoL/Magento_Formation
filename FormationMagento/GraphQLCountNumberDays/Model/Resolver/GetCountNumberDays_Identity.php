<?php
declare (strict_types = 1);

namespace FormationMagento\GraphQLCountNumberDays\Model\Resolver\Navigation;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class Identity implements IdentityInterface
{
    /** @var string */
    private $cacheTag = "formation_magento_graphql_count_number_days";

    /**
     * Get PromoBanners identities from resolved data
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {
        return [ $this->cacheTag ];
    }
}