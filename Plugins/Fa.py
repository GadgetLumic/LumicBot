from asyncio import coroutine

from aiohttp import get

from plugins import LumicbotPlugin



urls_regex = re.compile(r"""((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.‌​][a-z]{2,4}/)(?:[^\s()<>]+|(([^\s()<>]+|(([^\s()<>]+)))*))+(?:(([^\s()<>]+|(‌​([^\s()<>]+)))*)|[^\s`!()[]{};:'".,<>?«»“”‘’]))""", re.DOTALL)

fa_regex = re.compile(r"^https?://(www.)?furaffinity.net/(full|view)")



plugin_furaffinity = LumicbotPlugin("FurAffinity helper", author="Freddy Roykyr Sturmovik", description="A few helpers for Furaffinity links")



@plugin_furaffinity.trigger

@coroutine

def trigger(message):

    return "furaffinity.net" in message



@plugin_furaffinity.helplines

@coroutine

def help():

    return []



@coroutine

def is_nsfw(fa_link):

    response = yield from get(fa_link)

    body = yield from response.text()

    return "You are not allowed" in body



def get_fa_links(text):

    urls = [u[0] for u in urls_regex.findall(text)]

    return [url for url in urls if fa_regex.match(url)]



@plugin_furaffinity.group_chat

@coroutine

def group(message, sender, response):

   fa_links = get_fa_links(message)

   for link in fa_links:

       if (yield from is_nsfw(link)):

           yield from response('↑\u2757 Gadget-Gadget! WARNING! The following artwork or file is classified as "Adult material". Proceed at your own risk')

           break
