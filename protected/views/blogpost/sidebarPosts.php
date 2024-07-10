<?php
// Assuming $dataProvider is already defined in your controller action

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_sidebarPostItem', // This is the view file for each item
    'template' => '{items}', // Only render the items without any wrapper
));
?>
