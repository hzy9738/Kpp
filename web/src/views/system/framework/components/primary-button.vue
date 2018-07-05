<style lang="less">
    @import "./../home.less";
</style>

<template>
    <div style="float: right">
        <!--<Button  v-permission="['system-framework-move']" class="right" type="ghost" @click.stop="depart_down(item)">下移</Button>-->
        <!--<Button  v-permission="['system-framework-move']" class="right" type="ghost" @click.stop="depart_top(item)">上移</Button>-->
        <Button  v-permission="['system-framework-delete']" class="right" type="ghost" @click.stop>
            <Poptip
                    confirm
                    title="您确认删除此部门吗？"
                    :transfer='true'
                    @on-ok="depart_delete(item)">
                删除
            </Poptip>
        </Button>
        <Button v-permission="['system-framework-new']" class="right" type="ghost" @click.stop="depart_child(item)">+下一级</Button>
        <Button v-permission="['system-framework-update']"  class="right" type="ghost" @click.stop="depart_rename(item)">修改</Button>
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
                ident: 0
            };
        },
        props: {
            item:{}
        },

        methods: {
            depart_top (data) {
                this.$emit('depart_top', data)
            },
            depart_down (data) {
                this.$emit('depart_down', data)
            },
            depart_delete (data) {
                this.$emit('depart_delete', data)
            },
            depart_child (data) {
                this.$emit('depart_child', data)
            },
            depart_rename (data) {
                this.$emit('depart_rename', data)
            },
        },
        watch: {
            // depart () {
            //     this.item = this.depart
            // }
        }
    };
</script>
