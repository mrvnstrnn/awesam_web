<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.0/viewer.min.js" integrity="sha512-11Ip09cPitpyapqTnApnxupcQdX1fzWkRZZoEU+I0+IxrVxORGThseKL6O2s+qbBN7aTw7SDbk+rWFZ/LVmB7g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script src="{{ asset('js/supervisor-view-sites.js') }}"></script>
<script src="{{ asset('js/view_site.js') }}"></script>
<script>

  var progress = $('#completed_activities').text();
  
//   alert(progress);

  $(".circle-progress-primary")
    .circleProgress({
      value: parseFloat(progress) / 100.0,
      size: 200,
      lineCap: "round",
      fill: { color: "#3f6ad8" },
    })
    .on("circle-animation-progress", function (event, progress, stepValue) {
      $(this)
        .find("small")
        .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
    });

    $("#start_date").flatpickr(
      { 
        maxDate: new Date()
      }
    );

    Dropzone.autoDiscover = false;
    $(".dropzone_files").dropzone({
      addRemoveLinks: true,
      maxFiles: 1,
      // maxFilesize: 1,
      paramName: "file",
      url: "/upload-file",
      init: function() {
          this.on("maxfilesexceeded", function(file){
              this.removeFile(file);
          });
      },
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (file, resp) {
        var sam_id = this.element.attributes[1].value;
        var sub_activity_id = this.element.attributes[2].value;
        var file_name = resp.file;

        $.ajax({
          url: "/upload-my-file",
          method: "POST",
          data: {
            sam_id : sam_id,
            sub_activity_id : sub_activity_id,
            file_name : file_name,
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (resp) {
            if (!resp.error){
              $(".child_div_"+sub_activity_id).load(window.location.href + " .child_div_"+sub_activity_id );
              console.log(resp.message);
            } else {
              toastr.error(resp.message, "Error");
            }
          },
          error: function (file, response) {
            toastr.error(resp.message, "Error");
          }
        });
          
      },
      error: function (file, resp) {
          toastr.error(resp.message, "Error");
      }
  });

    $(".view_file").on("click", function (){
        $("#view_file_modal").modal("show");

        var extensions = ["pdf", "jpg", "png"];
        console.log(extensions.includes($(this).attr('data-value').split('.').pop()) == true);
        if( extensions.includes($(this).attr('data-value').split('.').pop()) == true) {     
          htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 380px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';

        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + $(this).attr('data-value') + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }

        // htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 380px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';
                
        $('.modal-body .container-fluid').html(htmltoload); 
    });

</script>
