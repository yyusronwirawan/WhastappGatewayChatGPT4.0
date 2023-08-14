const {
    extractMessageContent,
    jidNormalizedUser,
    proto,
} = require("@whiskeysockets/baileys")

function getTypeMessage(message) {
    const type = Object.keys(message)
    var restype = (!['senderKeyDistributionMessage', 'messageContextInfo'].includes(type[0]) && type[0]) || // Sometimes message in the front
        (type.length >= 3 && type[1] !== 'messageContextInfo' && type[1]) || // Sometimes message in midle if mtype length is greater than or equal to 3
        type[type.length - 1] || Object.keys(message)[0] // common case
    return restype
}

const serialize = (conn, m, options = {}) => {
    if (!m) return m
    let M = proto.WebMessageInfo
    m = M.fromObject(m)
    if (m.key) {
        m.from = jidNormalizedUser(m.key.remoteJid || m.key.participant)
        m.fromMe = m.key.fromMe
        m.id = m.key.id
        m.isBot = m.id.startsWith("BAE5") && m.id.length == 16
        m.isGroup = m.from.endsWith("@g.us")
        m.sender = jidNormalizedUser(m.fromMe && conn.user?.id || m.key.participant || m.from || "")
    }
    if (m.message) {
        m.type = getTypeMessage(m.message)
        m.msg = (m.type == 'viewOnceMessage' ? m.message[m.type].message[getTypeMessage(m.message[m.type].message)] : m.message[m.type])
        m.message = extractMessageContent(m.message)
        m.mentions = m.msg?.contextInfo ? m.msg?.contextInfo.mentionedJid : []
        m.quoted = m.msg?.contextInfo ? m.msg?.contextInfo.quotedMessage : null
        if (m.quoted) {
            m.quoted.type = getTypeMessage(m.quoted)
            m.quoted.msg = m.quoted[m.quoted.type]
            m.quoted.mentions = m.msg.contextInfo.mentionedJid
            m.quoted.id = m.msg.contextInfo.stanzaId
            m.quoted.sender = jidNormalizedUser(m.msg.contextInfo.participant || m.sender)
            m.quoted.from = m.from
            m.quoted.isGroup = m.quoted.from.endsWith("@g.us")
            m.quoted.isBot = m.quoted.id.startsWith("BAE5") && m.quoted.id == 16
            m.quoted.fromMe = (m.quoted.sender == jidNormalizedUser(conn.user && conn.user?.id))
            m.quoted.text = m.quoted.msg?.text || m.quoted.msg?.caption || m.quoted.msg?.conversation || m.quoted.msg?.contentText || m.quoted.msg?.selectedDisplayText || m.quoted.msg?.title || ""
            let vM = m.quoted.fakeObj = M.fromObject({
                key: {
                    remoteJid: m.quoted.from,
                    fromMe: m.quoted.fromMe,
                    id: m.quoted.id
                },
                message: m.quoted,
                ...(m.quoted.isGroup ? { participant: m.quoted.sender } : {})
            })
            m.quoted.delete = () => conn.sendMessage(m.quoted.from, { delete: vM.key })
            m.quoted.download = (pathFile) => conn.downloadMediaMessage(m.quoted.msg, pathFile)
        }
    }
    m.download = (pathFile) => conn.downloadMediaMessage(m.msg, pathFile)
    m.body = m.text = m.message?.conversation || m.message?.[m.type]?.text || m.message?.[m.type]?.caption || m.message?.[m.type]?.contentText || m.message?.[m.type]?.selectedDisplayText || m.message?.[m.type]?.title || ""
    m.reply = (text, chatId = m.from, options = {}) => Buffer.isBuffer(text) ? conn.sendFile(chatId, text, 'file', '', m, { ...options }) : conn.sendText(chatId, text, m, { ...options })

    return m
}


module.exports = serialize
