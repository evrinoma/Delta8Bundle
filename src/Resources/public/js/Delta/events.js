export default class DeltaEvents {
    constructor() {
        this.url = {
            'api_delta_journal': location.protocol + '//' + location.hostname + '/evrinoma/api/delta8/journal',
            'api_delta_object': location.protocol + '//' + location.hostname + '/evrinoma/api/delta8/object'
        };
    }

    getUrl(alias, requestParam) {
        let url = '';
        if (this.url[alias] !== undefined) {
            url = this.url[alias];
        }
        let query = '';
        if (requestParam !== undefined) {
            query = '?';
            query += new URLSearchParams(requestParam).toString();
        }

        return url + query;
    }

    beforeUpdate() {
        console.log('beforeUpdate Delta8Events');
    }

    afterUpdate() {
        console.log('afterUpdate Delta8Events');
    }

    callBackDelete() {
        console.log('callBackDelete Delta8Events');
    }

    callBackDate() {
        console.log('callBackDate Delta8Events');
    };
}
