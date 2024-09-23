<?php 
# Call in main template
echo $this->extend('layouts/default');

# Meta title Section 
echo $this->section('heading');
echo $title;
echo $this->endSection();

echo $this->section('sidebar'); 

echo $this->endSection();

# Main Content
echo $this->section('content'); 

$this->db = db_connect();
?>
<style>
    .fc .fc-daygrid-block-event .fc-event-time, .fc .fc-daygrid-block-event .fc-event-title, .fc .fc-daygrid-dot-event .fc-event-time, .fc .fc-daygrid-dot-event .fc-event-title {
    color: black;
    font-weight: bold;
    text-transform: uppercase;
}
</style>
<!--begin::Post-->
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div class="container-xxl">
        <!--begin::Products-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <select class="form-control form-control-lg" name="department_id" id="department_id" onchange="fun_change_department(this.value)">
                          <option value="">All Department</option>
                              <?php
                              if($departments){
                                  foreach($departments as $department){
                                      $selected = "";
                                      if($select_department_id == $department['id']){
                                          $selected = "selected";
                                      }
                                      echo "<option ".$selected." value='".$department['id']."'>".$department['department']."</option>";
                                  }
                              }
                              ?>
                      </select>
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
        <!--begin::Card body-->
            <div class="card-body pt-0">
               <div id="calendar"></div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
<?php
$sched_data = array();
foreach ($products as $product) {
    if($product['all_employee'] == 1){
        $product['first_name'] = 'All';
        $product['last_name'] = 'Employee';
        $product['color_code'] = '#FF7F7F';
    }
	$sched_data[]=$product;
}
$sched = json_encode($sched_data);
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="/public/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>

<script>
var scheds = $.parseJSON('<?php echo $sched ?>');
	$(function(){
		var Calendar = FullCalendar.Calendar;
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()
		
		var calendarEl = document.getElementById('calendar');
		var calendar = new Calendar(calendarEl, {
                        headerToolbar: {
                            left  : 'prev,next today',
                            center: 'title',
                            //right : 'prevYear,prevYear,year,listYear,dayGridFourWeek,timelineCustom,dayGridYear,dayGridMonth,timeGridWeek,timeGridDay'
                            right : 'dayGridMonth,timeGridWeek,timeGridDay,listYear'
                        },
                        views: {
                            dayGridFourWeek: {
                              type: 'dayGrid',
                              duration: { weeks: 4 }
                            }
                          },
                          timelineCustom: {
                            type: 'timeline',
                            buttonText: 'Year',
                            dateIncrement: { years: 1 },
                            slotDuration: { months: 1 },
                            visibleRange: function (currentDate) {
                                return {
                                    start: currentDate.clone().startOf('year'),
                                    end: currentDate.clone().endOf("year")
                                };
                            }
                        },
                        droppable: false,
                        themeSystem: 'bootstrap',
                        //Random default events
                        events:function(event,successCallback){
                            var days = moment(event.end).diff(moment(event.start),'days')
                            var events = []
							Object.keys(scheds).map(k=>{
                                events.push({
									title          : scheds[k].first_name+' '+scheds[k].last_name,
									start          : moment(scheds[k].start_date).format("YYYY-MM-DD"),// HH:mm
									end          : moment(scheds[k].end_date).format("YYYY-MM-DD"),// HH:mm
									backgroundColor: scheds[k].color_code,//'var(--success)'
									borderColor    : scheds[k].color_code,//'var(--primary)'
									'data-id'      : scheds[k].id
								})
							})
							console.log(events)
                            successCallback(events)
                        },
                        eventClick:function(info){
				 			sched_id = info.event.extendedProps['data-id']
				 			//window.location.href = '<?php echo url_to('Calendar::detail');?>?id='+sched_id;
				 			window.open(
                              '<?php echo url_to('Calendar::detail');?>?p='+sched_id,
                              '_blank' // <- This is what makes it open in a new window.
                            );
    //                         uni_modal("Schedule Details","schedules/view_details.php?id="+sched_id)
                        },
                        // editable  : true,
                        selectable: true,
                        editable: false,
				});

	calendar.render();
	})

function fun_change_department(department_id){
    window.location.href = '<?php echo url_to('Calendar::list');?>?department_id='+department_id;
}	

</script>
 
<?php 

echo $this->endSection();