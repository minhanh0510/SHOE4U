    </div> <!-- .main-content -->
</div> <!-- .admin-container -->

<footer class="admin-footer">
    <div class="container" style="max-width: none; padding: 0 24px;">
        <div style="border-top: 1px solid var(--fog); padding: 20px 0; text-align: center; color: var(--mist); font-size: 12px;">
            <i class="fas fa-heart" style="color: var(--blue);"></i> Shoe4U Admin Panel &copy; 2026 - Bản quyền thuộc về Shoe4U
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Auto hide alerts after 3 seconds
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.transition = 'opacity 0.4s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 400);
    });
}, 3000);
</script>
</body>
</html>