export default function extractObjectProp(object) {
    const res = {}
    for (const [key, value] of Object.entries(object)) {
        console.log((`${key}: ${value}`));
        res[key] = value
    }
    return res
}