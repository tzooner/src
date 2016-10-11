<?php
/**
 *  
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 19.1.2015
 */


class Constants {

    const WS_URL_GUIDES = 'guides';
    const WS_URL_COMMISSIONS = 'commissions';
    const WS_URL_CARDS = 'cards';
    const WS_URL_USERS = 'users';
    const WS_URL_REPORTS = 'reports';
    const WS_URL_CLAIMS = 'claims';
    const WS_URL_PRINTS = 'prints';
    const WS_URL_OTHERS = 'others';

    const APP_SETTINGS_DATE_FORMAT = 'Y-m-d';
    const APP_SHOW_GUIDES_PER_PAGE = 10;
    const APP_PAGINATION_DISPLAY_BUTTONS = 9;
    const APP_GUIDES_ORDER_DEFAULT = '_last_action_date';
    const APP_COMMISSION_ORDER_DEFAULT = '_commission_id';
    const APP_GUIDES_SORT_DEFAULT = 'DESC';
    const APP_COMMISSION_SORT_DEFAULT = 'DESC';

    // Time in second of refresh all guides count on page 'Show guides'
    // It is only for increase application speed in pagination
    const APP_ALL_GUIDE_COUNT_INT = 60;
    /**
     * Currencies in application
     * Every currency has their option
     * @var array
     */
    public static $APP_CURRENCIES = array(
        'EUR' => array('COLOR'=>'#DFF0D8'),
        'CHF' => array('COLOR'=>'#EEE')
    );

}