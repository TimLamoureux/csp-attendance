<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 18-02-04
 * Time: 23:37
 */

wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', null, false, true );
wp_add_inline_script( 'google-charts', 'google.charts.load("current", {packages:["corechart","table"]});' );
//wp_add_inline_script( 'google-charts', "google.charts.load('current', {packages:['corecharts']});" );
wp_enqueue_script( CA_TEXTDOMAIN  . '-report-patroller', plugins_url( 'public/assets/js/report-patroller.js', CA_PLUGIN_ABSOLUTE ), array('google-charts'), false, true );


?>



<template id="ca-report-users-template">
	<div class="ca-report-user">
		<h3 class="ca-report-user-name"></h3>
<!--        <div class="ca-report-user-team">Teams</div>-->
        <div class="ca-chart-container"></div>
        <div class="ca-report-user-type"></div>
        <div class="ca-report-dow"></div>
        <span class="ca-report-user-my-team"></span>
		<span class="ca-report-user-all-team"></span>
		<div class="ca-report-user-events">
            <div class="event-list-title h4"><i class="fas fa-angle-down" style="margin-right:10px;"></i>Events attended</div>
            <div class="ca-report-user-events-table"></div>
        </div>
        <div style="clear:both"></div>
	</div>
</template>
