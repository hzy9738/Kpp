<style lang="less">
    @import "./../home.less";
</style>

<template>
    <div style="float: right">
        <Button v-permission="['system-role-delete']" class="right" type="ghost" @click.stop>
            <Poptip
                    confirm
                    title="您确认删除此角色吗？"
                    :transfer='true'
                    @on-ok="depart_delete(item.id)">
                删除
            </Poptip>
        </Button>
        <Button v-if="item.role !== '人事' && item.role !== '总经理'" v-permission="['system-role-rename']" class="right" type="ghost" @click.stop="role_rename(item.id,item.role)">重命名</Button>
        <Button v-permission="['system-role-set']" class="right" type="ghost" @click.stop="role_permission(item.id)">权限分配</Button>
        <Button v-permission="['system-role-detail']" class="right" type="ghost" @click.stop="role_watch(item.id)">权限详情</Button>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    depart: '',
                },
                depart_id: 0,
            };
        },
        props: {
            item:{}
        },

        methods: {
            role_watch (id) {
                this.$emit('role_watch', id)
            },

            depart_delete (id) {
                this.$emit('role_delete', id)
            },

            role_rename (id,name) {
                this.$emit('role_rename', id , name)
            },
            role_permission (id) {
                this.$router.push({
                    name: 'set_permission',
                    query:{ id : id }
                });
            }
        },
        watch: {
            // depart () {
            //     this.item = this.depart
            // }
        }
    };
</script>
