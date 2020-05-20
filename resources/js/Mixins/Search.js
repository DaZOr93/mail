


export default {

    methods: {
        mySearch(html) {
            let pattern = '(<[^>]*>)|' + this.search.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
            document.querySelectorAll('.open__body').forEach(function (n) {
                if (!n.dataset.textOriginal) {
                    n.dataset.textOriginal = n.innerHTML;
                }
                n.innerHTML = n.dataset.textOriginal.replace(new RegExp(pattern, 'gi'), function (m0, m1) {
                    if (m1) return m0;
                    return '<span class="highlight">' + m0 + '</span>';
                });
            });
            if (this.search.length === 0) {
                this.message.html = '';
                setTimeout(() => {
                    this.message.html = html;
                }, 1)
            }
        },

    }


}
