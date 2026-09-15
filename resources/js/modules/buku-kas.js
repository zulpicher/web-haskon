export default function bukuKas() {
    return {
        modal: null,

        editId: null,
        editType: '',
        editDate: '',
        editDescription: '',
        editAmount: '',
        editAction: '',

        detail: {},

        historySearch: '',
        historyType: '',
        historyStartDate: '',
        historyEndDate: '',

        openAdd() {
            this.modal = 'add';
        },

        openEdit(transaction) {
            this.editId = transaction.id;
            this.editType = transaction.type;
            this.editDate = transaction.date;
            this.editDescription = transaction.description;
            this.editAmount = transaction.amount;

            this.editAction =
                this.$root.dataset.transactionUrl + '/' + transaction.id;

            this.modal = 'edit';
        },

        openDetail(transaction) {
            this.detail = transaction;
            this.modal = 'detail';
        },

        openHistory() {
            this.modal = 'history';
        },

        closeModal() {
            this.modal = null;
        },

        resetHistory() {
            this.historySearch = '';
            this.historyType = '';
            this.historyStartDate = '';
            this.historyEndDate = '';
        }
    };
}
