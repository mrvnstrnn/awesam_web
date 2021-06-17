<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

</script>
