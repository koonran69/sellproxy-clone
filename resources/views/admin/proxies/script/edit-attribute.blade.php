<script>
    $(document).ready(function() {
         // Khi chọn thuộc tính
         $('#attribute-select').on('change', function() {
             let attrId = $(this).val();
             
             // Ẩn toàn bộ biến thể cũ nếu chọn thuộc tính mới
             $('.variation-option').removeClass('selected').find('i').removeClass('ti-circle-check').addClass('ti-circle');
 
             if (attrId) {
                 $('#variation-select-container').show();
             } else {
                 $('#variation-select-container').hide();
                 $('#variation-data-container').hide();
             }
         });
 
         // Chọn biến thể
         $(document).on('click', '.variation-option', function() {
             let icon = $(this).find('i');
             $(this).toggleClass('selected');
 
             if ($(this).hasClass('selected')) {
                 icon.removeClass('ti-circle').addClass('ti-circle-check');
             } else {
                 icon.removeClass('ti-circle-check').addClass('ti-circle');
             }
 
             // Kiểm tra nếu có biến thể được chọn, hiển thị form nhập liệu
             if ($('.variation-option.selected').length > 0) {
                 $('#variation-data-container').show();
             } else {
                 $('#variation-data-container').hide();
             }
         });
 
         // Validate khi submit
         $('form').on('submit', function(e) {
             if ($('.variation-option.selected').length === 0) {
                 alert('Vui lòng chọn ít nhất một biến thể');
                 e.preventDefault();
             }
         });
     });
 </script>
 