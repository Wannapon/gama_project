<template>
    <div class="container ">
        <h4>List Room</h4>
        <div class="row">
            <div class="col-lg-4 col-xs-12" v-for="(list,index) in ListRoom.slice().reverse().slice((page*data_in_page),(page+1)*data_in_page)" :key="index">
                <div @click="seethisRoom(list.vr_id)">
                Room Name: <b>{{list.vr_title}}</b> <br>
                Description: {{list.vr_description.slice(0,10)}} ... <br>
                Create Date: {{list.vr_create_date}} <br>
                Update Date: {{list.vr_update_date}} <br>
                </div>
                <br>
            </div>
        </div>
        <div class="row" v-if="length_page > 0">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="Second group">
                    <button type="button" class="btn btn-light" @click="seenextPage(1)" title="First page"><<</button>
                    <button
                    type="button"
                    class="btn btn-light"
                    v-for=" (run_page,index) in length_page "
                    @click="seenextPage(run_page)"
                    v-bind:class="{ active: isActive[index+1] }"
                    v-if=" run_page >= page_start && run_page <= page_end "
                    >{{run_page}}</button>
                    <button type="button" class="btn btn-light" @click="seenextPage(length_page)" title="Last page">>></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            page: 0,
            data_in_page: 9,
            length_page: 0,
            page_start: 0,
            page_end: 0,
            isActive: []
        };
    },
    methods:{
        seenextPage(num_page) {
            this.$router.push({
                name: "listroom",
                params: { Page: num_page }
            });
        },
        seethisRoom(thisroom){
            this.$router.push({name:'listvideos',params:{RoomID:thisroom}});
        },
    },
    computed:{
        ListRoom(){
            var setpage = this.$route.params.Page;
            var listroom = this.$store.getters.getVideo_Room;
            var p_conpute = 2;
            var p_start = setpage;
            var p_end = Math.ceil(setpage / 1 + p_conpute);

            this.page = setpage - 1;
            this.length_page = Math.ceil(listroom.length / this.data_in_page); // set page all
            // set start && end paging
            if (setpage > p_conpute) {
                p_start = setpage - p_conpute;
            } else {
                p_start = -(setpage - p_conpute) - p_conpute;
                p_end = p_end + p_start + p_conpute + 1;
            }
            if (p_end >= this.length_page) {
                p_start = p_start + (this.length_page - setpage - p_conpute);
            }
            this.page_start = p_start;
            this.page_end = p_end;

            this.isActive = [];
            for (var i = 0; i <= this.length_page; i++) {
                if (i == this.$route.params.Page) {
                    this.isActive.push(true);
                } else {
                    this.isActive.push(false);
                }
            }
            return listroom
        },
    },
    created(){
        this.$store.dispatch("initDataVideo_Room")
    }
}
</script>

