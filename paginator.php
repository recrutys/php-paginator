<?php

class Paginator
{
	public $page;
	public $items;
	public $link;
	public $pagesCount;

	public function __construct($db, $page, $limit, $query, $link)
	{
		$this->page = $page ?: 1;

		$limit = $limit ?: 5;
		$offset = $limit * ($this->page - 1);
		$queryWithLimit = $query . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
		$sqlItemsCount = count($db->query($query)->fetchAll());

		$this->items = $db->query($queryWithLimit)->fetchAll();
		$this->link = $link;
		$this->pagesCount = ceil($sqlItemsCount / $limit);
	}

	public function result()
	{
		return $this->items;
	}

	public function getPageNavHtml()
	{
		$list = '';
		$pages = $this->pagesCount;

		if ($pages > 1)
		{
			for ($i = 1; $i <= $pages; $i++)
			{
				$class = '';

				if ($this->page == $i)
				{
					$class .= 'pageNav-selected';
				}

				$list .= "<a class=\"$class\" href=\"$this->link?page=$i\">$i</a>";
			}

			return '<div class="pageNav-container">' . $list . '</div>';
		}
	}
}

?>

<style>
    .pageNav-container a
    {
        padding: 6px 10px;
        background: #cdc1c1;
        margin-right: 10px;
        border-radius: 5px;
        text-decoration: none;
        color: #000;
    }
    .pageNav-container
    {
        margin-bottom: 10px;
        width: fit-content;
    }

    .pageNav-selected
    {
        background: #5c5b5b !important;
        color: #fff !important;
    }
</style>
