
export const columns1 = [
    {
        key: 'order',
        title: 'ID',
        align: 'center',
        width: 100
    },
    {
        key: 'name',
        title: '姓名',
        align: 'center',
    },
    {
        key: 'phone',
        title: '手机号码',
        align: 'center',
    },
    {
        key: 'role',
        title: '权限角色',
        align: 'center'
    },
    {
        key: 'created_at',
        title: '创建时间',
        align: 'center'
    },
    {
        key: 'stop_at',
        title: '停用时间',
        align: 'center'
    },
    {
        key: 'handle',
        width: 270,
        title: '操作',
        align: 'center',
        handle: ['look', 'edit', 'parse', 'ground']
    }
];
