</div> </div> <script>
    function updateJam() {
        const target = document.getElementById('clock');
        if (target) {
            const sekarang = new Date();
            target.innerText = sekarang.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit', 
                hour12: false 
            });
        }
    }
    setInterval(updateJam, 1000); 
    updateJam();
</script>
</body>
</html>