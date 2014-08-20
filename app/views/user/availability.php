<style>
.fc-state-highlight {background-color: #2B6A47;}
</style>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<h2>Availablility</h2>
		<div class="row">
			<div id="weekCalendar"></div>
		</div>
	</div>
</div>

<div class="modal fade" id="addEntry">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title">Add Availablity</h4>
      		</div>
            <form class="form" role="form" id="eventForm" method="post" action="<?php echo URL::to('/schedule/availability/create'); ?>">
      		<div class="modal-body">
        			<div class="form-group">
        				<label for="category">Weekday</label>
        				<p id="weekday-text"></p>
        				<input type="hidden" name="weekday" class="form-control" />
        			</div>
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <div class="input-group date" id="start_time">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                            <input data-format="hh:mm" type='text' name="start_time" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
			            <label>End Time</label>
			            <div class="input-group addon" id="end_time">
			                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
			                <input data-format="hh:mm" type="text" class="form-control" name="end_time" />
			            </div>
			        </div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		<input type="Submit" class="btn btn-primary" value="Add Availability" />
      		</div>
            </form>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(function() {
	$('#start_time, #end_time').datetimepicker({
		pickDate: false,
		useSeconds: false, 
		pick12HourFormat: true, 
	});
	
});
var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";

function getWeekday(day) {
	var d = new Date(day);

	return {
		id: d.getDay(),
		day: weekday[d.getDay()]
	}
}

$('#weekCalendar').fullCalendar({
        // put your options and callbacks here
        
        events: function(start, end, callback) {
	        $.ajax({
	            url: '<?php echo URL::to("/schedule/availability/avail"); ?>',
	            dataType: 'json',
	            success: function(doc) {
	            	console.log(doc);
	                var events = [];
	                for (i in doc) {
	                	
	                    events.push({
	                    	id: doc[i].id,
	                        start: new Date(doc[i].start_date + ' ' + doc[i].start_time),
	                        end: new Date(doc[i].start_date + ' ' + doc[i].end_time),
	                        allDay: false,

	                    });
	                };
	                console.log(events);
	                callback(events);
	            }
	        });
	    },
	    defaultView: 'agendaWeek',
	    header: false,
	    editable: true,
	    eventColor: '#2C2C2C',
	    minTime: '06:00:00',
	    maxTime: '22:00:00',
	    allDaySlot: false,
	    dayClick: function(event, jsEvent, view) {
	    	var day = getWeekday(event);
	    	$('#weekday-text').html(day.day);
	    	$('input[name="weekday"]').val(day.id);
	    	$('#addEntry').modal('show');
	    },
	    eventMouseover: function( event, jsEvent, view ) { 
	    	//console.log(this);
	    	$(this).attr('title', event.description);
	    	$(this).tooltip({
		      position: {
		        my: "center bottom-20",
		        at: "center top",
		        using: function( position, feedback ) {
		          $( this ).css( position );
		          $( "<div>" )
		            .addClass( "arrow" )
		            .addClass( feedback.vertical )
		            .addClass( feedback.horizontal )
		            .appendTo( this );
		        }
		      }
		    });
		    $(this).tooltip('show');
	    },
	    eventClick: function(event, jsEvent, view) {
	    	console.log(event);
	    	
	    	//$.post('<?php echo URL::to("/calendar/entries/destroy"); ?>', {id: event.id});
	    },
	    eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
	    	var start_time = new Date(event.start);
	    	var end_time = new Date(event.end);
	        
	        var eventArr = {
	        	id: event.id,
	        	weekday: start_time.getDay(),
	        	start_time: formatDate(start_time),
	        	end_time: formatDate(end_time)
	        }
	        $.post('<?php echo URL::to("/schedule/availability/update"); ?>', eventArr);
	        //cal.update(eventArr);
	        
    	},
    	eventResize: function(event) {
    		console.log(event);
    		var start_time = new Date(event.start);
	    	var end_time = new Date(event.end);
	        
	        var eventArr = {
	        	id: event.id,
	        	weekday: start_time.getDay(),
	        	start_time: formatDate(start_time),
	        	end_time: formatDate(end_time)
	        }
	        console.log(eventArr);
	        $.post('<?php echo URL::to("/schedule/availability/update"); ?>', eventArr);
    	}
    });

function formatDate(date) {
	return date.getHours() + ':' +date.getMinutes();
}
</script>