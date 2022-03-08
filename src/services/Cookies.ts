export default class Cookies {
    static set(name: string, value: any, expireDays: number): void {
        let cookie = name.trim() + "=" + encodeURIComponent(value)
        cookie += "; max-age=" + (expireDays * 60 * 60 * 24) + "; path=/"
        document.cookie = cookie
    }

    static get(name: string): any {
        let cookie = document.cookie
        let data = cookie.split(name + "=")[1]
        return (data) ?data.split(";")[0] :null
    }

    static delete(name: string): void {
        this.set(name, null, -1)
    }
}