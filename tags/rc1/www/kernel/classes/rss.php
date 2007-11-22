<?
class RSS extends DomDocument {

    function __construct($title, $link, $description, $language, $pubDate, $lastBuildDate, $managingEditor, $webMaster) {

        // Установка этого документа как XML 1.0 с корневым
        // <rss> элементом, имеющим атрибут version="2.0" 
        parent::__construct('1.0', 'UTF-8');
        $rss = $this->createElement('rss');
        $rss->setAttribute('version', '2.0');
        $this->appendChild($rss);

		
		if (!$pubDate) $pubDate=time();
		if (!$lastBuildDate) $lastBuildDate=time();
		
        // Создание элемента <channel> с  субэлементами <title>, <link>,
        // и <description> 
        $channel = $this->createElement('channel');
        $channel->appendChild($this->makeTextNode('title', $title));
        $channel->appendChild($this->makeTextNode('link', $link));
        $channel->appendChild($this->makeTextNode('description', $description));
        $channel->appendChild($this->makeTextNode('language', $language));
        $channel->appendChild($this->makeTextNode('pubDate', date("r",$pubDate)));
        $channel->appendChild($this->makeTextNode('lastBuildDate', date("r",$lastBuildDate)));
        $channel->appendChild($this->makeTextNode('docs', 'http://blogs.law.harvard.edu/tech/rss'));
        $channel->appendChild($this->makeTextNode('generator', 'LabCMS Feeder'));
        if (preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i',$managingEditor)) $channel->appendChild($this->makeTextNode('managingEditor', $managingEditor));
        if (preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i',$webMaster)) $channel->appendChild($this->makeTextNode('webMaster', $webMaster));
		
		
        // Добавление <channel> подчиненного <rss>
        $rss->appendChild($channel);

        // Установка вывода с переводами строки и пробелами
        $this->formatOutput = true;
    }

    // Эта функция добавляет <item> к <channel>
    function addItem($title, $link, $description, $pubDate, $guid) {
	
		if (!$pubDate) $pubDate=time();
        // Создание элемента <item> с субэлементами <title>, <link>
        // и <description> 
        $item = $this->createElement('item');
        $item->appendChild($this->makeTextNode('title', $title));
        $item->appendChild($this->makeTextNode('link', $link));
        $item->appendChild($this->makeTextNode('description', $description));
        $item->appendChild($this->makeTextNode('pubDate', date("r",$pubDate)));
        $item->appendChild($this->makeTextNode('guid', ($guid?$guid:$link)));
		
        // Добавление <item> к <channel>
        $channel = $this->getElementsByTagName('channel')->item(0);
        $channel->appendChild($item);
    }

    // Вспомогательная функция для создания полностью 
    // текстового элемента (без субэлементов)
    private function makeTextNode($name, $text) {
        $element = $this->createElement($name);
        $element->appendChild($this->createTextNode($text));
        return $element;
    }
}
?>