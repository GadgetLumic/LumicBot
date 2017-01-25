LumicCommands.py

import re

from .plugins import LumicbotPlugin

from asyncio import coroutine



commands_re = re.compile(r"^(/..*?)( +(\w+))?\b")



Lumiccommands = LumicbotPlugin("Lumic commands", author="Freddy Roykyr Sturmovik", description="Roleplaying commands")



# all attributes of "User" work here, mainly firstname and lastname

# as well as "argument" which is either the firstname of the user

# or the argument they supplied.

commands = {

        "/poke": "Gadget-Gadget! WirrrWirrr! *it pokes {argument}*,

        "/peck": "Gadget-Gadget! *it pecks {argument}*",

        "/hug": "Gadget-Gadget! Wiiiiirr.. *it has hugged {argument}*"

        "/preen": "Gadget-Gadget! *it preens scrupulously {argument}*",

        "/floof": "*it floofs up {argument}*",
        
        "/scritch": "WzztWzztWzztWzztWzztWzzt.. *it's scritching {argument}*",
        
        "/zap": "Gadget-Gadget! You will be,deleted. *it grabs and zaps {argument}*",

        "/incinerate": "Gadget-Gadget! You will be,incinerated. *it opens the beak and through a flamethrower incinerates {argument}*",

        "/pizza": "Gadget-Gadget! It's;Pizza,time! ^v^ *it bakes and serves a pizza to {argument}*",

        "/spaghetti": "Gadget-Gadget! Spaghetti you said? Excellent! *it rocks out and then prepares a typical spaghetti dish for {argument}*",
    
        "/fish and chips": "Gadget-Gadget! *it walks away and then returns with some perfectly fried fish and chips for {argument}*",

        "/rare steak": "Gadget-Gadget! *it serves a deliciously rare entrecôte steak for {argument}*",

        "/fish": "*it tosses a fish to {argument}*",
   
        "/energydrink": "*it offers an ice cold energy drink to {argument}*",
       
        "/wine": "*Gadget-Gadget! *it opens the hand,a bluish glow surrounds his palm and a chilled wine glass is teleported on his steel hand*",
   
        "/beer": "Gadget-Gadget! HA-HA-HAAAA! OKTOBERFEEEEST! *after the imitation of the Medic's taunt it extract the wrist gun,and opens a beer keg by firing at the cork*",
    
        "/cider": "*it approaches with a Cider bottle of a notorious brand,and serves it to {argument};at the optimum temperature of 12,7 °C*",
    
        "/vodka": "*it retrieves the chilled Vodka from the freezer and pours it on the {argument}'s tumbler*",
    
        "/coffee": "Gadget-Gadget! *it starts a good brand of coffee,after a few minutes the coffee it's served to {argument}* Gadget-Gadget! Caution: Scorching temperature.",
    
        "/tea": " Gadget-Gadget! *It serves some British brand tea after the necessary time for an optimum infusion*",
   
        "/Soda": " Gadget-Gadget! *It pops open a Glass bottle of soda,of your desired brand*",
   
        "/Cybus Vitex": "*it serves a Vitex soft drink*",
 
        "/dispens a cookie": "Gadget-Gadget! *it approaches to {argument} and dispens a cookie*",

        "/cake": "It throws a nice slice of cake to {argument}"

        "/upgrade": "Gadget-Gadget! You must be upgraded. *it grabs {argument} and drags it in a conversion chamber",
}



@Lumiccommands.trigger

@coroutine

def trigger(text):

    text = text.lower()

    for command in commands.keys():

        if text.startswith(command):

            return True



@Lumiccommands.helplines

@coroutine

def helptext():

    return [

        '"%s" or "%s <name>"' % (command, command)

        for command in commands.keys()

    ] 



@Lumiccommands.group_chat

@coroutine

def group(text, sender, response):

    match = commands_re.match(text)

    command, argument = match.group(1), match.group(3)



    context = sender._asdict()

    if argument:

        context["argument"] = argument

    context.setdefault("argument", sender.firstname)



    if command.lower() in commands:

        reaction = commands[command.lower()]

        if isinstance(command, str):

            yield from response(reaction.format(**context))

            return

        yield from reponse((yield from reaction(text, sender)))
