<?Php
class DOMDocumentCustom extends DOMDocument
{
    function __construct($version = null, $encoding = null) {
        parent::__construct($version, $encoding);
        //$this->registerNodeClass('DOMElement', 'XDOMElement');
    }

    /**
     * @param string $tagName tag name
     * @param DOMElement $parent parent element
     * @param array $attributes element attributes
     * @param string $value element value
     * @return DOMElement
     */
    public function createElement_simple($tagName, $parent=null, $attributes=null, $value='')
	{
		$element=$this->createElement($tagName);
		if($value!==false && is_string($value))
			$element->appendChild($this->createTextNode($value)); //http://stackoverflow.com/questions/22956330/domdocumentcreateelement-unterminated-entity-reference
		if(is_array($attributes))
		{
			foreach($attributes as $name=>$value)
			{
				$element->setAttribute($name,$value);
			}
		}
		if(!empty($parent))
			$parent->appendChild($element);
		return $element;
	}
}
