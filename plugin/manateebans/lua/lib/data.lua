--[[
	ManateeBans data processing library
	
]]--

function escapeCSV (s)
    if string.find(s, '[,"]') then
		s = '"' .. string.gsub(s, '"', '""') .. '"'
    end
    
	return s
end

function fromCSV (s)
    if not s then return {} end
    s = s .. ','        -- ending comma
    local t = {}        -- table to collect fields
    local fieldstart = 1
    repeat
        -- next field is quoted? (start with `"'?)
        if string.find(s, '^"', fieldstart) then
			local a, c
			local i  = fieldstart
            repeat
                -- find closing quote
                a, i, c = string.find(s, '"("?)', i+1)
            until c ~= '"'    -- quote not followed by quote?
            if not i then error('unmatched "') end
            local f = string.sub(s, fieldstart+1, i-1)
            table.insert(t, (string.gsub(f, '""', '"')))
            fieldstart = string.find(s, ',', i) + 1
        else                -- unquoted; find next comma
            local nexti = string.find(s, ',', fieldstart)
            table.insert(t, string.sub(s, fieldstart, nexti-1))
            fieldstart = nexti + 1
        end
    until fieldstart > string.len(s)
    
	return t
end

 -- Convert from table to CSV string
function toCSV (tt)
    local s = ""
    
	for _,p in pairs(tt) do
        s = s .. "," .. escapeCSV(p)
    end
     
    return string.sub(s, 2)      -- remove first comma
end

function table.contains(table, element)
    for _, value in pairs(table) do
        if value == element then
            return true
        end
    end
  
    return false
end

function isIPAddress(ip)
	if not ip then return false end
	
	local a,b,c,d=ip:match("^(%d%d?%d?)%.(%d%d?%d?)%.(%d%d?%d?)%.(%d%d?%d?)$")
	
	a=tonumber(a)
	b=tonumber(b)
	c=tonumber(c)
	d=tonumber(d)
	
	if not a or not b or not c or not d then return false end
	if a<0 or 255<a then return false end
	if b<0 or 255<b then return false end
	if c<0 or 255<c then return false end
	if d<0 or 255<d then return false end

	return true
end
