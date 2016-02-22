class LovelyBox
  class Config
    #
    # @param [Hash] type
    # @return [Hash]
    #
    def self.get(type = :dist)
      case type
      when :dist
        dist
      when :local
        local
      else
        raise ArgumentError.new 'Please pass in :dist or :local'
      end
    end

    private

    #
    # @return [Hash]
    #
    def self.dist
      if @dist
        @dist
      else
        @dist = YAML.load(File.read(File.join(LovelyBox.root, 'conf/lovelybox/dist.yml')))
      end
    end

    #
    # @return [Hash]
    #
    def self.local
      if @local
        @local
      else
        @local = YAML.load(File.read(File.join(LovelyBox.root, 'lovelybox.yml')))
      end
    end
  end
end
