export default function taskManager(groups = []) {
    return {
        groups,
        modal: null, // 'add', 'edit', 'detail', 'delete'
        
        // Data Task aktif untuk Detail / Edit / Delete
        task: null,

        // --- State Form Tambah ---
        addGroup: '',
        addUsers: [],

        // --- State Form Edit ---
        editGroup: '',
        editUsers: [],
        editAction: '',

        // --- State Form Delete ---
        deleteAction: '',

        // Getters untuk multi-assignee berdasarkan group yang dipilih
        get addMembers() {
            const group = this.groups.find(g => String(g.id) === String(this.addGroup));
            return group ? group.users : [];
        },

        get editMembers() {
            const group = this.groups.find(g => String(g.id) === String(this.editGroup));
            return group ? group.users : [];
        },

        // Trigger saat group berubah
        changeAddGroup() {
            this.addUsers = [];
        },

        changeEditGroup() {
            this.editUsers = [];
        },

        // --- Modal Actions ---
        openAdd() {
            this.addGroup = '';
            this.addUsers = [];
            this.modal = 'add';
        },

        openDetail(taskData) {
            this.task = taskData;
            this.modal = 'detail';
        },

        openEdit(taskData) {
            this.task = taskData;
            this.editGroup = taskData.group_id;
            this.editUsers = taskData.assignees ? taskData.assignees.map(u => u.id) : [];
            this.editAction = `/tasks/${taskData.id}`;
            this.modal = 'edit';
        },

        openDelete(taskData) {
            this.task = taskData;
            this.deleteAction = `/tasks/${taskData.id}`;
            this.modal = 'delete';
        },

        closeModal() {
            this.modal = null;
            setTimeout(() => { this.task = null; }, 300); // Bersihkan setelah animasi selesai
        }
    };
}