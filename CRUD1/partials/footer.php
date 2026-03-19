 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
 <script>
     let alert = document.querySelector('.alert');

     setTimeout(() => {
         let params = new URLSearchParams(window.location.search);

         let success = params.get("success") || params.get("delete-success");

         if (success)
             window.location.assign("/CRUD1/list.php");
     }, 2000);
 </script>
 </body>

 </html>