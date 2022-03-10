<?php
namespace FormationMagento\PremierModule\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Serialize\SerializerInterface;

/*

Dans ce fichier, nous hériterons de la classe ObserverInterface.
Et obtiendra le devis du produit, la valeur de la commande et le définira dans le choix d'une option supplémentaire.

*/

class QuoteSubmitObserver implements ObserverInterface
{
	private $serializer;
	public function __construct(SerializerInterface $serializer)
	{
		$this->serializer = $serializer;
	}

	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		try {
			$quote = $observer->getQuote();
			$order = $observer->getOrder();
			$quoteItems = [];

			// Map Quote Item with Quote Item Id
			foreach ($quote->getAllItems() as $quoteItem) {
				$quoteItems[$quoteItem->getId()] = $quoteItem;
			}

			foreach ($order->getAllVisibleItems() as $orderItem) {
				$quoteItemId = $orderItem->getQuoteItemId();
				$quoteItem = $quoteItems[$quoteItemId];
				$additionalOptions = $quoteItem->getOptionByCode('additional_options');

				if (!is_null($additionalOptions)) {
					// Get Order Item's other options
					$options = $orderItem->getProductOptions();
					// Set additional options to Order Item
					$options['additional_options'] = $this->serializer->unserialize($additionalOptions->getValue());
					$orderItem->setProductOptions($options);
				}
			}
		} catch (\Exception $e) {
			// catch error if any
		}
	}
}