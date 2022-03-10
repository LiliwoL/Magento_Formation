<?php
namespace FormationMagento\PremierModule\Plugin;
use Magento\Framework\Serialize\SerializerInterface;

class SetOrderItemValue
{
	private $serializer;

	public function __construct(SerializerInterface $serializer)
	{
		$this->serializer = $serializer;
	}

	public function aroundConvert(\Magento\Quote\Model\Quote\Item\ToOrderItem $subject, callable $proceed, $quoteItem, $data)
	{
		// get order item
		$orderItem = $proceed($quoteItem, $data);

		if(!$orderItem->getParentItemId() && $orderItem->getProductType() == \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE){
			if ($additionalOptionsQuote = $quoteItem->getOptionByCode('additional_options')) {
				//To do
				// - check to make sure element are not added twice
				// - $additionalOptionsQuote - may not be an array
				if($additionalOptionsOrder = $orderItem->getProductOptionByCode('additional_options')){
					$additionalOptions = array_merge($additionalOptionsQuote, $additionalOptionsOrder);
				}
				else{
					$additionalOptions = $additionalOptionsQuote;
				}

				if(!is_null($additionalOptions)){
					$options = $orderItem->getProductOptions();
					$options['additional_options'] = $this->serializer->unserialize($additionalOptions->getValue());
					$orderItem->setProductOptions($options);
				}
			}
		}

		return $orderItem;
	}
}

