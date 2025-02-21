	   /* DATERANGEPICKER */
	   
		function init_daterangepicker() {

			if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
			
			var cb = function(start, end, label) {
			  $('#calendar span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			};

			var optionSet1 = {
			  startDate: moment().subtract(29, 'days'),
				endDate: moment(),
			  minDate: '01/01/2017',
			  showDropdowns: true,
			  showWeekNumbers: true,
			  timePicker: false,
			  timePickerIncrement: 1,
			  timePicker12Hour: true,
			  ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			  },
			  opens: 'left',
			  buttonClasses: ['btn btn-default'],
			  applyClass: 'btn-small btn-primary',
			  cancelClass: 'btn-small',
			  format: 'MM/DD/YYYY',
			  separator: ' to ',
			  locale: {
				applyLabel: 'Submit',
				cancelLabel: 'Clear',
				fromLabel: 'From',
				toLabel: 'To',
				customRangeLabel: 'Custom',
				daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
				monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				firstDay: 1
			  }
			};
			
			$('#calendar span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
			$('#calendar').daterangepicker(optionSet1, cb);
			$('#calendar').on('show.daterangepicker', function() {
	
			});
			$('#calendar').on('hide.daterangepicker', function() {
			});
			$('#calendar').on('apply.daterangepicker', function(ev, picker) {
				val1 = $('input[name="daterangepicker_start"]').val();
				val2 = $('input[name="daterangepicker_end"]').val();
				d = new Date(val1);
				val1 = d.format('Y-m-d');
				d = new Date(val2);
				val2 = d.format('Y-m-d');
				$('div.table-responsive').load("http://bintree.local:81/index.php/cabinet/dashboard/0/" + val1 + '/' + val2 + " div.table-responsive");
				$('ul.pagination').css('display', 'none');
			});
			$('#calendar').on('cancel.daterangepicker', function(ev, picker) {
			});
			$('#options1').click(function() {
			  $('#calendar').data('daterangepicker').setOptions(optionSet1, cb);
			});
			$('#options2').click(function() {
			  $('#calendar').data('daterangepicker').setOptions(optionSet2, cb);
			});
			$('#destroy').click(function() {
			  $('#calendar').data('daterangepicker').remove();
			});
   
		}
   	   