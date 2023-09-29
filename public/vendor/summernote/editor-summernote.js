(function($) { 
  "use strict";
  $(document).ready(function() {
      $('#summernote').summernote({
          codeviewFilter: true,
          codeviewIframeFilter: true,
          placeholder: 'Hello Bootstrap',
          tabsize: 2,
          height: 500,
          toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'italic', 'underline', 'clear']],
              // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
              ['fontname', ['fontname']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'hr']],
              ['view', ['fullscreen', 'codeview' ]],   // remove codeview button 
              ['help', ['help']]
            ],
      });
      $('#summernotex').summernote({
        codeviewFilter: true,
        codeviewIframeFilter: true,
        placeholder: 'Hello Bootstrap',
        tabsize: 2,
        height: 500,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['insert', ['link']],
            ['view', ['fullscreen' ]],   // remove codeview button 
            ['help', ['help']]
          ],
    });
  });
})(jQuery);