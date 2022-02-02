<?php
    $title_for_layout = __('Terms & Conditions of guestify', true);
    $this->set('title_for_layout', $title_for_layout);


    // Set specific meta tags
    $meta_keywords = __('terms, conditions, legals, guestify, rules, policy', true);
    $meta_description = __('On this page you read the terms and conditions of guestify.', true);
    echo $this->Html->meta(array('name' => 'keywords', 'content' => $meta_keywords), null, array('inline' => false));
    echo $this->Html->meta(array('name' => 'description', 'content' => $meta_description), null, array('inline' => false));


    // Facebook OpenGraph
    $seo_image = Configure::read('NON_SSL_HOST').'/graphics/logos/300/guestify_300_regular.jpg';
    echo $this->Html->meta(array('property' => 'og:title', 'content' => $title_for_layout), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:description', 'content' => $meta_description), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:image', 'content' => $seo_image), null, array('inline' => false));
    echo $this->Html->meta(array('property' => 'og:url', 'content' => Configure::read('NON_SSL_HOST') . $this->here), null, array('inline' => false));


    // Crumbs
    $locale = $this->Session->read('Config.language');
    if(empty($locale)) {
        $this->Html->addCrumb(__('Home', true), '/', array('escape' => false));
    } else {
        $this->Html->addCrumb(__('Home', true), '/' . substr($locale, 0, 2), array('escape' => false));
    }
?>


<div class="clearfix">
    <?php /* UNCOMMENT TO ACTIVATE LANGUAGE SELECTOR 
    <div class="btn-group pull-right">
        <?php $codes = Configure::read('Locales'); ?>
        <?php foreach($codes as $locale => $name) { ?>
            <?php 
                echo $this->Html->link(
                    // $this->Html->image('/img/flags/'.substr($locale, 0, 2).'.png'), array(
                    //     'controller' => 'users', 
                    //     'action' => 'setInterfaceLanguage', $locale
                    // ), array(
                    //     'class' => 'btn btn-link', 'escape' => false
                    // )
                    $this->Html->image('/img/flags/'.substr($locale, 0, 2).'.png'), 
                    DS . substr($locale, 0, 2) . DS . 'terms', 
                    array(
                        'class' => 'btn btn-link', 'escape' => false
                    )
                ); ?>
        <?php } ?>
    </div>
    */?>
    <h1><?php echo __('Terms & Conditions', true); ?></h1>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-8">
                            <?php $locale = $this->Session->read('Config.language'); ?>
                            <?php if($locale == 'eng') { ?>
                                <?php
                                    /*
                                    $myfile = fopen("/files/terms.txt", "r") or die("Unable to open file!");
                                    echo fread($myfile,filesize("/files/terms.txt"));
                                    fclose($myfile);
                                    */
                                    echo nl2br('
                                    Under these terms and conditions, we agree on the use of Guestify provided by Guestify. The use of Guestify is done by remote data access on a software-based application (Saas, Software As A Service).

                                    §1 - Service
                                    (1) The provider\'s services take place according to the following terms and conditions, the terms of reference and the compensation list.
                                    (2) Terms and conditions of a customer that deviate from these terms and conditions, do not apply. They are also valid without explicit objection of Guestify.

                                    §2 - Contract
                                    (1) The extent of use of Guestify is described on https://guestify.net in the product description on the website.
                                    (2) The prices for the provided services with the contract are visible in the price information on the website https://guestify.net. These are net prices where the statutory VAT is not included.
                                    (3) The payment must be made in advance.
                                    (4) In case of default of payment of the customer, Guestify is entitled to block the user account ten days after the occurrence of default.

                                    §3 - Extent of Use
                                    (1) All data within Guestify are invariably owned by the customer.
                                    (2) The customer can use the data collected in Guestify marketing purposes without restriction.
                                    (3) The customer is not entitled to use its account by a third party or to provide the login information provided by him to third parties.
                                    (4) digital: cube GmbH & Co KG is freely allowed to modify the design of the software and at any time to modify the service, restrict, expand or withdraw. Guestify is free to engage or contract third parties to improve its provisioned services.

                                    §4 - Liability
                                    (1) The liability in the event of intent or gross negligence of Guestify is not limited. In the case of slight negligence Guestify is unlimited liable for injuries to life, limb or health.
                                    (2) In addition, digital: cube GmbH & Co KG limits its liability to the breach of contract. The liability is then limited to the replacement of contractually typically foreseeable damages.
                                    (3) Guestify is not liable for damage or expenses incurred, if § 536 BGB incurred. This leaves the above rules unaffected.

                                    §5 - Contract Conclusion
                                    (1) By registering its data, the customer accepts the terms and conditions.
                                    (2) The contract is concluded by the acceptance of this contract offer by Guestify and the customer. This acceptance is valid by the activation of access of the customer.

                                    $6 - Contract Period
                                    (1) The contract for the use of the software runs on indefinitely. If the customer chooses a different price plan than the monthly payment, a different contract term can be selected with another plan period (half or yearly). The closed contract is terminable at any time by the end of the contract period. Notice of termination must be in writing or is also possible by the client in the account settings.
                                    (2) Termination rights based on highly important reasons persist for cause.

                                    $7 - Jurisdiction, Applicable Law, changes
                                    (1) To the extent permitted by law, the place of jurisdiction between the parties is Cologne, Germany. This applies only if the parties are merchants.
                                    (2) Exclusively German law applies.
                                    (3) Changes or differing agreements must be in writing.

                                    Last change: 15.11.2020

                                    ');
                                ?>
                            <?php } elseif($locale == 'deu') { ?>
                                <?php


                                    echo nl2br('
                                    Im Rahmen dieser Allgemeinen Geschäftsbedingungen vereinbaren wir die Nutzung von Guestify, die durch Guestify bereitgestellt werden. Die Nutzung Guestify erfolgt durch Datenfernzugriff auf die softwarebasierte Anwendung (Saas, Software As A Service).

                                    §1 Leistung
                                    (1) Die Leistungen des Anbieters erfolgen gemäß nachfolgender AGB, der Leistungsbeschreibung sowie der Vergütungsliste.
                                    (2) Allgemeine Geschäftsbedingungen des Kunden, die von diesen Allgemeinen Geschäftsbedingungen abweichen, gelten nicht. Sie gelten auch ohne ausdrücklichen Widerspruch Guestify nicht.

                                    §2 - Vertragsinhalt
                                    (1) Der Leistungs-/Nutzungsumfang von Guestify wird in der Produktbeschreibung auf der Internetseite https://guestify.net beschrieben.
                                    (2) Die Preise für die zur Verfügung gestellten Leistungen im Rahmen des Vertrages sind in der Preisinformation auf der Internetseite https://guestify.net abrufbar und im Rahmen des bestellten Vorgangs vereinbart worden. Es handelt sich dabei um Nettopreise, in denen die gesetzliche Umsatzsteuer nicht enthalten ist.
                                    (3) Die Zahlung ist  per Vorkasse zu leisten.
                                    (4) Bei Zahlungsverzug des Kunden ist Guestify berechtigt, zehn Tage nach Verzugseintritt den Benutzeraccount zu sperren.

                                    §3 - Nutzungsumfang
                                    (1) Alle erhobenen Daten innerhalb von Guestify befinden sich ausnahmslos im Besitz des Kunden.
                                    (2) Der Kunde kann die in Guestify erhobenen Daten für eigene Marketingzwecke ohne Einschränkung nutzen.
                                    (3) Der Kunde ist nicht berechtigt, seinen Account durch Dritte nutzen zu lassen oder die von ihm erstellten Zugangsdaten Dritten zur Verfügung zu stellen oder weiter zu geben.
                                    (4) Guestify ist frei in der Gestaltung der Software und jederzeit berechtigt, den Service zu ändern, einzuschränken, zu erweitern, oder ganz einzustellen. Guestify ist bei der Erbringung seiner Leistung frei, diese auch durch Dritte nach eigener Wahl zu erbringen.

                                    §4 - Haftung
                                    (1) Die Haftung im Falle von Vorsatz oder grober Fahrlässigkeit Guestify wird nicht beschränkt. Für Verletzungen von Leben, Körper oder Gesundheit haftet Guestify im Falle leichter Fahrlässigkeit unbeschränkt.
                                    (2) Darüber hinaus beschränkt Guestify seine Haftung auf die Verletzung wesentlicher Vertragspflichten. Die Haftung wird dann auf den Ersatz des vertragstypisch vorhersehbaren Schaden beschränkt.
                                    (3) Guestify haftet nicht für Schäden oder entstandener Aufwendungen, die gem. § 536 a BGB entstanden sind. Dies lässt die vorstehenden Vorschriften unberührt.

                                    §5 - Vertragsschluss
                                    (1) Mit der Registrierung seiner Daten akzeptiert der Kunde die allgemeinen Geschäftsbedingungen.
                                    (2) Der Vertrag kommt durch die Annahme dieses Vertragsangebots seitens Guestify und des Kunden zustande. Diese Annahme erfolgt durch die Freischaltung des Zugangs des Kunden.

                                    §6 - Vertragslaufzeit
                                    (1) Der Vertrag über die Nutzung der Software läuft auf unbestimmte Zeit. Wählt der Kunde eine andere als die monatliche Zahlungsweise, wird als Vertragslaufzeit der jeweilige Vorauszahlungszeitraum (halb-, jährlich) vereinbart. Der geschlossene Vertrag ist jederzeit zum Ende der Vertragslaufzeit kündbar. Die Kündigungserklärungen bedürfen der Textform oder sind durch den Kunden in den Accounteinstellungen möglich.
                                    (2) Kündigungsrechte aus wichtigem Grund bleiben bestehen.

                                    §7 - Gerichtsstand, anwendbares Recht, Änderungen
                                    (1) Soweit gesetzlich zugelassen, wird als Gerichtsstand zwischen den Parteien Köln vereinbart. Dies gilt nur dann, wenn die Parteien Kaufleute sind.
                                    (2) Zwischen den Parteien gilt ausschließlich deutsches Recht.
                                    (3) Änderungen oder abweichende Vereinbarungen bedürfen der Textform.

                                    Stand: 15.11.2020


                                    ');
                                ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
