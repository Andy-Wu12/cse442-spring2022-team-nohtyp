export default function extractObjectProp(object) {
    const res = {}
    for (const [key, value] of Object.entries(object)) {
        res[key] = value
    }
    return res
}