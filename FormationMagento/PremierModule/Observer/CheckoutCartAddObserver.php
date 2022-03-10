<?php
namespace FormationMagento\PremierModule\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Serialize\SerializerInterface;

/*

Ces observateurs sont une classe Magento qui peut affecter les performances de toute logique métier. L'Observer est exécuté lorsque les événements configurés pour les surveiller sont distribués par le gestionnaire d'événements.

Dans un premier temps, nous allons créer un dossier nommé Observateur à la racine du module.

Après cela, nous allons créer un fichier PHP pour le premier événement auquel nous avons donné le nom de l'observateur dans le fichier d'événement.

Dans le CaissePanierAjouterObservateur fichier, nous vérifions la quantité de produit si la quantité est supérieure à zéro, puis définissons l'étiquette 'Délai de livraison du produit : 7 -21 jours', si la quantité est nulle ou inférieure à zéro, définissez l'étiquette 'Délai de livraison des commandes spéciales : 16 - 22 semaines»

*/

class CheckoutCartAddObserver implements ObserverInterface
{
	protected $request;
	private $serializer;
	protected $layout;
	protected $storeManager;

	public function __construct(RequestInterface $request, SerializerInterface $serializer, StoreManagerInterface $storeManager, LayoutInterface $layout)
	{
		$this->_request = $request;
		$this->serializer = $serializer;
		$this->layout = $layout;
		$this->storeManager = $storeManager;
	}
	public function execute(\Magento\Framework\Event\Observer $observer){
		$item = $observer->getQuoteItem();
		$additionalOptions = array();
		$product = $observer->getProduct();
		$productId=$product->getId();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
		$qty=$StockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());

		if($qty > 0){
			$label='Product Instock Lead Time: 7 -21 days' ;
		}else{
			$label='Special Order Lead Time: 16 - 22 Weeks' ;
		}
		if ($additionalOption = $item->getOptionByCode('additional_options')) {
			$additionalOptions = $this->serializer->unserialize($additionalOption->getValue());
		}
		$additionalOptions[] = [
			'label' => 'Lead Time',
			'value' => $label
		];

		if (!is_null($additionalOptions)) {
			$item->addOption(array(
				'product_id' => $item->getProductId(),
				'code' => 'additional_options',
				'value' => $this->serializer->serialize($additionalOptions)
			));
		}
	}
}

