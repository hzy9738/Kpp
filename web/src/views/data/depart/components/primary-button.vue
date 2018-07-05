<style lang="less">
    @import "./../home.less";
</style>

<template>
    <div style="float: right">
        <Button v-permission="['data-depart-move']"  class="right" type="ghost" @click.stop="depart_down(item.id)">下移</Button>
        <Button v-permission="['data-depart-move']"  class="right" type="ghost" @click.stop="depart_top(item.id)">上移</Button>
        <Button v-permission="['data-depart-delete']"  class="right" type="ghost" @click.stop="showPopTip(item.id)">
            <Poptip
                    v-model="visible[item.id]"
                    confirm
                    title="您确认删除此部门吗？"
                    :transfer='true'
                    @on-ok="depart_delete(item.id)">
                删除
            </Poptip>
        </Button>
        <Button v-permission="['data-depart-new']"  class="right" type="ghost" @click.stop="depart_child(item.id)">+下一级</Button>
        <Button v-permission="['data-depart-rename']" class="right" type="ghost" @click.stop="depart_rename(item.id,item.depart)">重命名</Button>
    </div>
</template>
l
<script>
    export default {
        data () {
            return {
                formData :{
                    depart: '',
                },
                depart_id: 0,
                visible:[]
            };
        },
        props: {
            item:{}
        },

        methods: {
            depart_top (id) {
                this.$emit('depart_top', id)
            },
            depart_down (id) {
                this.$emit('depart_down', id)
            },
            depart_delete (id) {
                this.$emit('depart_delete', id)
            },
            depart_child (id) {
                this.$emit('depart_child', id)
            },
            depart_rename (id,name) {
                this.$emit('depart_rename', id , name)
            },
            showPopTip(id){
                this.visible = []
                this.$set(this.visible,id,true)
            }
        },
        watch: {
            // depart () {
            //     this.item = this.depart
            // }
        }
    };
</script>
