<?php
$args = [
    'post_type' => 'events',
];

$events = new WP_Query($args);
?>

<script>
jQuery(function() {
    jQuery('#calendar').fullCalendar({
        contentHeight: 560,
        events: [
            <?php
            /*
            My solution to recurrency was to create a single event, and repeat them just on the overview archive, 
            changing the dates here. To be able to do that, I decided to customize the way to present the dates on the single page
            for the events, and also, create an rule to determine when the recurrence should stop (assuming an event can't go on forever).

            The code below has the goal to calculate how many times the event will repeat, and then, add days, months or years
            to appear on the correct date on calendar.

            To the calendar, I choose to use FullCalendar library, an customizable and opensource event calendar, working under Javascript.
            */

            while($events->have_posts()):
                $events->the_post();

                $startday = date_create(rwmb_meta('start'));
                $recurrence = rwmb_meta('recurrence');
                $recurrence_limit = date_create(rwmb_meta('recurrence_limit'));
                $interval = date_diff($startday, $recurrence_limit);
                $repeat = $interval->format('%a') + 1;

                if($recurrence == 'None') {
                    $repeat = 0;
                }
                if($recurrence == 'Daily') {
                    $repeat = $interval->format('%a') + 1;
                }
                if($recurrence == 'Monthly') {
                    $repeat = ($interval->format('%a') + 1)/30;
                }
                if($recurrence == 'Yearly') {
                    $repeat = ($interval->format('%a') + 1)/365;
                }

                $start = rwmb_meta('start');
                $end = rwmb_meta('end');

                for($i = 0; $i<=$repeat; $i++) {
                    if($recurrence == 'None') {
                        $start_date = date("Y-m-d H:i",strtotime($start . '+' . $i . 'Days'));
                        $end_date = date("Y-m-d H:i",strtotime($end . '+' . $i . 'Days'));
                    }
                    if($recurrence == 'Daily') {
                        $start_date = date("Y-m-d H:i",strtotime($start . '+' . $i . 'Days'));
                        $end_date = date("Y-m-d H:i",strtotime($end . '+' . $i . 'Days'));
                    }
                    if($recurrence == 'Monthly') {
                        $start_date = date("Y-m-d H:i",strtotime($start . '+' . $i . 'Months'));
                        $end_date = date("Y-m-d H:i",strtotime($end . '+' . $i . 'Months'));
                    }
                    if($recurrence == 'Yearly') {
                        $start_date = date("Y-m-d H:i",strtotime($start . '+' . $i . 'Years'));
                        $end_date = date("Y-m-d H:i",strtotime($end . '+' . $i . 'Years'));
                    }
            ?>
            {
              title: '<?php echo rwmb_meta('title');?>',
              start: '<?php echo $start_date?>',
              end: '<?php echo $end_date; ?>',
              allday: <?php echo rwmb_meta('allday'); ?>,
              url: '<?php echo get_permalink();?>'
            },
            <?php
                }
            endwhile; 
            ?>
          ]
      });

});
</script>

<div class="overviewEventCalendar" id='calendar'></div>
