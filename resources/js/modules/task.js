export default function taskCreateForm(groups = []) {
    return {
        groups,
        selectedGroup: '',
        selectedUser: '',

        get members() {
            const group = this.groups.find(
                group => String(group.id) === String(this.selectedGroup)
            );

            return group ? group.users : [];
        },

        changeGroup() {
            this.selectedUser = '';
        },
    };
}