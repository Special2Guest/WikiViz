<?php
$xmlstr = <<< XML
<?xml version='1.0' standalone='yes'?>

<weights>
    <category>
        <cat_name>Woerter</cat_name>
        <rabsolute />
        <min_value>500</min_value>
        <max_value>2000</max_value>
        <neg_weight>-10</neg_weight>
        <neutral_weight>0</neutral_weight>
        <pos_weight>10</pos_weight>
    </category>
    <category>
        <cat_name>Verlinkungen</cat_name>
        <rabsolute />
        <min_value>10</min_value>
        <max_value>50</max_value>
        <neg_weight>-5</neg_weight>
        <neutral_weight>0</neutral_weight>
        <pos_weight>5</pos_weight>
    </category>
    <category>
        <cat_name>Quellen</cat_name>
        <rabsolute />
        <min_value>5</min_value>
        <max_value>10</max_value>
        <neg_weight>-10</neg_weight>
        <neutral_weight>0</neutral_weight>
        <pos_weight>10</pos_weight>
    </category>	
    <category>
        <cat_name>Bilder</cat_name>
        <rrelative />
        <min_value>1000</min_value>
        <max_value>250</max_value>
        <neg_weight>-10</neg_weight>
        <neutral_weight>0</neutral_weight>
        <pos_weight>10</pos_weight>
    </category>
    <category>
        <cat_name>Lesenswert</cat_name>
        <rboolean />
        <weight>10</weight>
    </category>
    <category>
        <cat_name>Exzellent</cat_name>
        <rboolean />
        <weight>10</weight>
    </category>
    <category>
        <cat_name>Informativ</cat_name>
        <rboolean />
        <weight>15</weight>
    </category>
    <category>
        <cat_name>Gute Bilder</cat_name>
        <rboolean />
        <weight>15</weight>
    </category>
    <category>
        <cat_name>Belege Fehlen</cat_name>
        <rboolean />
        <weight>-15</weight>
    </category>
    <category>
        <cat_name>Ueberarbeitung</cat_name>
        <rboolean />
        <weight>-5</weight>
    </category>
    <category>
        <cat_name>Lueckenhaft</cat_name>
        <rboolean />
        <weight>-10</weight>
    </category>
    <category>
        <cat_name>Unneutral</cat_name>
        <rboolean />
        <weight>-5</weight>
    </category>
    <category>
        <cat_name>Nur Liste</cat_name>
        <rboolean />
        <weight>-5</weight>
    </category>
    <category>
        <cat_name>Wiederspruch</cat_name>
        <rboolean />
        <weight>-15</weight>
    </category>
    <category>
        <cat_name>Nur Bilder</cat_name>
        <rboolean />
        <weight>-10</weight>
    </category>

</weights>

XML;

?>