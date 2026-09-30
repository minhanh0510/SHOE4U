$(document).ready(function() {
    // Xác nhận xóa
    $('.btn-delete').click(function(e) {
        if(!confirm('Bạn có chắc muốn xóa?')) {
            e.preventDefault();
        }
    });
    
    // Toggle sidebar trên mobile
    $('#menu-toggle').click(function() {
        $('.sidebar').toggleClass('active');
    });
    
    // Tự động ẩn alert sau 3 giây
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
    
    // Preview ảnh trước khi upload
    $('input[type="file"]').change(function() {
        const file = this.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        }
    });
});