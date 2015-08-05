<?php 
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class PruneTwigExtension extends \Twig_Extension
{
	/**
	 * @var array
	 */
	protected $input = array();

	/**
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Get name of the Twig extension
	 *
	 * @return string
	 */
	public function getName()
    {
        return 'Prune';
    }

	/**
	 * Get a list of the Twig filters this extension is providing
	 *
	 * @return array
	 */
	public function getFilters()
    {
        return array(
            'prune' => new Twig_Filter_Method($this, 'prune'),
        );
    }

	/**
	 * Convert a BaseModel into an array with the specified fields
	 *
	 * @param array  $input  The content being filtered
	 * @param array  $fields An array of the fields to keep
	 * @return array
	 * @throws Exception
	 */
	public function prune(array $input, array $fields)
    {
		if ( ! is_array($fields)) {
			throw new Exception(Craft::t('Map parameter needs to be an array.'));
		}

		if ( ! is_array($input)) {
			throw new Exception(Craft::t('Content passed is not an array.'));
		}

		$this->input = $input;
		$this->fields = $fields;

		$output = array();

		foreach ($input as $element) {
			if ( ! ($element instanceof BaseModel)) {
				continue;
			}

			$output[] = $this->returnPrunedArray($element);
		}

		return $output;
	}

	/**
	 * Given a BaseModel, return an array with only requested fields
	 *
	 * @param BaseModel $item
	 * @return array
	 */
	protected function returnPrunedArray(BaseModel $item)
	{
		$new_item = array();

		foreach ($this->fields as $key) {
			if (isset($item->{$key})) {
				if(is_object($item->{$key}) && method_exists($item->{$key}, 'first')) {
					$asset = $item->{$key}->first();

					if(is_object($asset) && method_exists($asset, 'getUrl') ) {
						$new_item[$key] = $asset->getUrl();
					} else {
						$new_item[$key] = null;
					}
				}
				else if(is_object($item->{$key}) && method_exists($item->{$key}, 'attributeNames')) {
					$new_item[$key] = new \stdClass();
					foreach($item->{$key}->attributeNames() as $attribute) {
						 $new_item[$key]->$attribute = $item->{$key}->{$attribute};
					} 
				}
				else {
					$new_item[$key] = $item->{$key};
				}
			}
		}

		return $new_item;
	}
}
