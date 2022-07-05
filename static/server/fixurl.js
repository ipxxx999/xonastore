/**
 * @description Takes a given resource URL and a requested base URL and will return a resource URL that is a full URL.
 * @example
 * // Returns "https://example.com/script.js"
 * fixUrl("fixurl.js", "https://example.com")
 * 
 * @param {string} resource_url The URL of the resource, ie "script.js".
 * @param {string} base_url The base url, ie "https://example.com".
 * @param {function} callback The callback.
 * 
 * @todo Add in IP support.
 */
exports.fixUrl = function(resource_url, base_url, callback) {
    if (base_url[base_url.length - 1] != "/") {
        base_url += "/"
    }


    exports.detectURL(resource_url, function(err, res) {
        if (err) {
            callback(err, null)
        }

        let url_type = res
        let http_prefix = "http"

        if (url_type === "full_url") {
            // Resource URL is fine, no fixing needed.
            callback(null, resource_url)

        } else if (url_type === "double_slash_url") {
            // Missing the "http:" or "https:".
            resource_url = `${http_prefix}:` + resource_url
            callback(null, resource_url)

        } else if (url_type === "httpless_url") {
            // Missing the "http://" or "https://".
            resource_url = `${http_prefix}://` + resource_url
            callback(null, resource_url)

        } else if (url_type == "slash_resource_name") {
            // A resource name, but with a slash. "fixurl.js" or "css.css".
            resource_url = base_url + resource_url.slice(1, resource_url.length)
            callback(null, resource_url)

        } else if (url_type == "resource_name") {
            // A resource name, like "script.js" or "styles.css".
            resource_url = base_url + resource_url
            callback(null, resource_url)

        } else {
            // Hmmm... The resource is of a URL we do not recognise.
            callback(
                Error(`Strange Resource URL: '${resource_url}'`), null
            )

        }

    })
}