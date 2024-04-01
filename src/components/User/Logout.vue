<script>
    module.exports = {
        mounted: function(){
            localStorage.clear();
            this.$router.push("/login");
        }
    }
</script>