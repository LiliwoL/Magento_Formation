<?php
declare(strict_types=1);

namespace FormationMagento\GraphQLCountNumberDays\Model\Resolver;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class GetCountNumberDays implements ResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($args['input']['month']) || !isset($args['input']['year'])) {
            throw new GraphQlInputException(__('Month or Year not indicated'));
        }

		// Si PHP n'est pas activé avec le calendrier
		if (!function_exists("cal_days_in_month"))
		{
			$out = $args['input']['month'] == 2 ? ($args['input']['year'] % 4 ? 28 : ($args['input']['year'] % 100 ? 29 : ($args['input']['year'] % 400 ? 28 : 29))) : (($args['input']['month'] - 1) % 7 % 2 ? 30 : 31);
		}else{
			$out = cal_days_in_month(CAL_GREGORIAN, $args['input']['month'], $args['input']['year']);
		}

        return [
			// La fonction cal_days_in_month nécessite que PHP soit compilé avec --enable-calendar
			'days' => $out
        ];
    }
}