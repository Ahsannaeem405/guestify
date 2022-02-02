<?php
/**
 * WidgetElementFixture
 *
 */
class WidgetElementFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('table' => 'widget_elements');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'widget_id' => '1',
			'type' => 'gsi',
			'param' => '',
			'created' => '2015-11-11 15:08:51',
			'modified' => '2015-12-02 13:00:55',
			'deleted' => 1
		),
		array(
			'id' => '2',
			'widget_id' => '1',
			'type' => 'ratingcount',
			'param' => '',
			'created' => '2015-11-11 15:08:52',
			'modified' => '2015-12-02 13:01:17',
			'deleted' => 0
		),
		array(
			'id' => '3',
			'widget_id' => '1',
			'type' => 'ratinglabel',
			'param' => '',
			'created' => '2015-11-11 15:08:52',
			'modified' => '2015-12-02 13:01:17',
			'deleted' => 0
		),
		array(
			'id' => '4',
			'widget_id' => '1',
			'type' => 'comment',
			'param' => 'top5',
			'created' => '2015-11-11 15:08:52',
			'modified' => '2016-01-06 17:07:44',
			'deleted' => 0
		),
		array(
			'id' => '5',
			'widget_id' => '2',
			'type' => 'gsi',
			'param' => '',
			'created' => '2015-11-11 15:09:36',
			'modified' => '2015-11-11 15:09:36',
			'deleted' => 0
		),
		array(
			'id' => '6',
			'widget_id' => '2',
			'type' => 'trend',
			'param' => '',
			'created' => '2015-11-11 15:09:36',
			'modified' => '2015-11-11 15:09:36',
			'deleted' => 0
		),
		array(
			'id' => '7',
			'widget_id' => '2',
			'type' => 'ratingcount',
			'param' => '',
			'created' => '2015-11-11 15:09:37',
			'modified' => '2015-11-11 15:09:37',
			'deleted' => 0
		),
		array(
			'id' => '8',
			'widget_id' => '2',
			'type' => 'ratinglabel',
			'param' => '',
			'created' => '2015-11-11 15:09:37',
			'modified' => '2015-11-11 15:09:37',
			'deleted' => 0
		),
		array(
			'id' => '9',
			'widget_id' => '3',
			'type' => 'gsi',
			'param' => '',
			'created' => '2015-11-11 15:10:11',
			'modified' => '2015-11-11 15:10:11',
			'deleted' => 0
		),
		array(
			'id' => '10',
			'widget_id' => '3',
			'type' => 'ratinglabel',
			'param' => '',
			'created' => '2015-11-11 15:10:11',
			'modified' => '2015-11-11 15:10:11',
			'deleted' => 0
		),
		array(
			'id' => '11',
			'widget_id' => '3',
			'type' => 'comment',
			'param' => 'last5',
			'created' => '2015-11-11 15:10:11',
			'modified' => '2015-12-15 10:09:50',
			'deleted' => 0
		),
		array(
			'id' => '12',
			'widget_id' => '4',
			'type' => 'gsi',
			'param' => '',
			'created' => '2015-11-16 10:49:02',
			'modified' => '2015-11-16 10:49:02',
			'deleted' => 0
		),
		array(
			'id' => '13',
			'widget_id' => '4',
			'type' => 'trend',
			'param' => '',
			'created' => '2015-11-16 10:49:02',
			'modified' => '2015-11-16 10:49:02',
			'deleted' => 0
		),
		array(
			'id' => '14',
			'widget_id' => '4',
			'type' => 'ratinglabel',
			'param' => '',
			'created' => '2015-11-16 10:49:02',
			'modified' => '2015-11-16 10:49:02',
			'deleted' => 0
		),
		array(
			'id' => '15',
			'widget_id' => '1',
			'type' => 'trend',
			'param' => null,
			'created' => '2015-11-19 16:09:21',
			'modified' => '2015-12-02 13:01:51',
			'deleted' => 0
		),
		array(
			'id' => '16',
			'widget_id' => '5',
			'type' => 'gsi',
			'param' => null,
			'created' => '2015-11-20 11:31:34',
			'modified' => '2015-11-20 11:44:44',
			'deleted' => 0
		),
		array(
			'id' => '17',
			'widget_id' => '5',
			'type' => 'trend',
			'param' => null,
			'created' => '2015-11-20 11:31:35',
			'modified' => '2015-11-20 11:44:44',
			'deleted' => 0
		),
		array(
			'id' => '18',
			'widget_id' => '5',
			'type' => 'comment',
			'param' => 'top5',
			'created' => '2015-11-20 11:31:35',
			'modified' => '2015-11-23 12:02:45',
			'deleted' => 0
		),
		array(
			'id' => '19',
			'widget_id' => '5',
			'type' => 'ratinglabel',
			'param' => null,
			'created' => '2015-11-20 11:49:13',
			'modified' => '2015-11-20 11:49:13',
			'deleted' => 0
		),
		array(
			'id' => '20',
			'widget_id' => '6',
			'type' => 'gsi',
			'param' => null,
			'created' => '2015-11-23 10:20:10',
			'modified' => '2015-11-23 10:20:10',
			'deleted' => 0
		),
		array(
			'id' => '21',
			'widget_id' => '6',
			'type' => 'trend',
			'param' => null,
			'created' => '2015-11-23 10:20:10',
			'modified' => '2015-11-23 11:54:17',
			'deleted' => 0
		),
		array(
			'id' => '22',
			'widget_id' => '6',
			'type' => 'comment',
			'param' => 'last5',
			'created' => '2015-11-23 10:20:23',
			'modified' => '2015-11-23 11:54:17',
			'deleted' => 0
		),
	);

}
