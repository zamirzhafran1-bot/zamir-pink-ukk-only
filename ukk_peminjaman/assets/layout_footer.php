</div> <!-- END CONTENT -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggleSidebarBtn");

    if(toggleBtn){
        toggleBtn.addEventListener("click", function(){

            sidebar.classList.toggle("collapsed");

            // Force resize chart / layout
            setTimeout(()=>{
                window.dispatchEvent(new Event("resize"));
            },300);

        });
    }

  

    // Counter animation
    document.querySelectorAll(".counter").forEach(counter=>{

        let target = parseInt(counter.innerText);
        let count = 0;

        function update(){
            count += Math.ceil(target/40);

            if(count < target){
                counter.innerText = count;
                requestAnimationFrame(update);
            }else{
                counter.innerText = target;
            }
        }

        update();
    });

});
</script>

</body>
</html>
